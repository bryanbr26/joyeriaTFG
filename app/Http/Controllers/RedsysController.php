<?php

namespace App\Http\Controllers;

use App\Models\PagoRedsys;
use App\Models\Pedido;
use App\Services\RedsysService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * RedsysController - Gestiona la integración con la pasarela de pago Redsys.
 *
 * Recibe notificaciones asíncronas (IPN), procesa respuestas de pago
 * exitosas y fallidas, y actualiza el estado de pedidos y stock.
 */
class RedsysController extends Controller
{
    /** @var \App\Services\RedsysService Servicio de comunicación con Redsys */
    private $redsys;

    /**
     * Constructor del controlador Redsys.
     *
     * @param \App\Services\RedsysService $redsys
     */
    public function __construct(RedsysService $redsys)
    {
        $this->redsys = $redsys;
    }

    /**
     * Procesa la notificación asíncrona (IPN) enviada por Redsys.
     *
     * Valida la firma, decodifica los parámetros y actualiza el estado
     * del pago y del pedido en una transacción segura.
     *
     * @param \Illuminate\Http\Request $request Petición POST de Redsys
     * @return \Illuminate\Http\Response Respuesta "OK" o "KO" según el resultado
     */
    public function notification(Request $request)
    {
        $merchantParameters = (string) $request->input('Ds_MerchantParameters');
        $signature = (string) $request->input('Ds_Signature');

        if ($merchantParameters === '' || $signature === '') {
            Log::warning('Notificacion Redsys incompleta.', ['ip' => $request->ip()]);

            return response('KO', 400);
        }

        try {
            $parameters = $this->redsys->decodeNotification($merchantParameters);
            $order = (string) ($parameters['Ds_Order'] ?? $parameters['DS_ORDER'] ?? '');

            if ($order === '' || !$this->redsys->isValidSignature($merchantParameters, $signature, $order)) {
                Log::warning('Firma Redsys invalida.', ['order' => $order]);

                return response('KO', 400);
            }

            $this->processNotification($parameters, $order);
        } catch (\Throwable $e) {
            Log::error('Error procesando notificacion Redsys.', [
                'message' => $e->getMessage(),
            ]);

            return response('KO', 400);
        }

        return response('OK');
    }

    /**
     * Muestra la pantalla de retorno tras un pago exitoso.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ok(Request $request)
    {
        return $this->returnToOrder($request, 'success', 'El pago se ha recibido. Estamos confirmando la notificación bancaria.');
    }

    /**
     * Muestra la pantalla de retorno tras un pago fallido o cancelado.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ko(Request $request)
    {
        return $this->returnToOrder($request, 'error', 'El pago no se ha completado. Puedes revisar el pedido o volver a intentarlo.');
    }

    /**
     * Procesa los parámetros de la notificación Redsys dentro de una transacción.
     *
     * Si el pago es exitoso marca el pago como completado. Si falla, restaura
     * el stock de los productos y marca el pedido como cancelado.
     *
     * @param array $parameters Parámetros decodificados de Redsys
     * @param string $order Número de pedido en Redsys
     * @return void
     */
    private function processNotification(array $parameters, string $order): void
    {
        DB::transaction(function () use ($parameters, $order) {
            $pago = PagoRedsys::where('numero_pedido_redsys', $order)->lockForUpdate()->firstOrFail();
            $pedido = Pedido::with('detalles.producto')->where('id', $pago->id_pedido)->lockForUpdate()->firstOrFail();

            $response = $parameters['Ds_Response'] ?? null;
            $amount = (string) ($parameters['Ds_Amount'] ?? '');
            $currency = (string) ($parameters['Ds_Currency'] ?? '');
            $merchantCode = (string) ($parameters['Ds_MerchantCode'] ?? '');
            $transactionType = (string) ($parameters['Ds_TransactionType'] ?? '');

            $isExpectedPayment =
                $amount === $this->redsys->amountToCents($pedido->total)
                && $currency === (string) config('redsys.currency')
                && $merchantCode === (string) config('redsys.merchant_code')
                && $transactionType === (string) config('redsys.transaction_type');

            $isPaid = $isExpectedPayment && $this->redsys->isSuccessfulResponse($response);

            if ($isPaid) {
                $pago->update([
                    'estado' => 'completado',
                    'codigo_autorizacion' => $parameters['Ds_AuthorisationCode'] ?? null,
                    'respuesta_json' => $parameters,
                ]);

                return;
            }

            if ($pago->estado !== 'error') {
                foreach ($pedido->detalles as $detalle) {
                    if ($detalle->producto) {
                        $detalle->producto->stock += $detalle->cantidad;
                        $detalle->producto->save();
                    }
                }
            }

            $pago->update([
                'estado' => 'error',
                'codigo_autorizacion' => $parameters['Ds_AuthorisationCode'] ?? null,
                'respuesta_json' => $parameters,
            ]);

            $pedido->update(['estado' => 'cancelado']);
        });
    }

    /**
     * Redirige al usuario a la vista de su pedido tras el retorno de Redsys.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $flashKey Tipo de mensaje flash (success|error)
     * @param string $message Texto del mensaje para el usuario
     * @return \Illuminate\Http\RedirectResponse
     */
    private function returnToOrder(Request $request, string $flashKey, string $message)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with($flashKey, $message);
        }

        $order = $this->extractOrderFromReturn($request);

        if ($order) {
            $pedido = Pedido::where('id_usuario', Auth::id())
                ->whereHas('pagoRedsys', function ($query) use ($order) {
                    $query->where('numero_pedido_redsys', $order);
                })
                ->first();

            if ($pedido) {
                return redirect()->route('pedidos.show', $pedido->id)->with($flashKey, $message);
            }
        }

        return redirect()->route('pedidos.index')->with($flashKey, $message);
    }

    /**
     * Extrae el número de pedido Redsys de los parámetros de retorno.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null Número de pedido o null si no se puede decodificar
     */
    private function extractOrderFromReturn(Request $request): ?string
    {
        $merchantParameters = (string) $request->input('Ds_MerchantParameters');

        if ($merchantParameters === '') {
            return null;
        }

        try {
            $parameters = $this->redsys->decodeNotification($merchantParameters);

            return $parameters['Ds_Order'] ?? null;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
