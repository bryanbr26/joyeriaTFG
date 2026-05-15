<?php

namespace App\Services;

use App\Models\PagoRedsys;
use App\Models\Pedido;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

/**
 * RedsysService - Servicio de integración con la pasarela de pago Redsys.
 *
 * Gestiona la construcción de formularios de pago, codificación de parámetros,
 * firma HMAC-SHA256, validación de notificaciones y utilidades de importes.
 */
class RedsysService
{
    /**
     * Devuelve la URL del entorno Redsys según la configuración.
     *
     * @return string URL de sandbox o producción
     */
    public function paymentUrl(): string
    {
        return config('redsys.environment') === 'production'
            ? config('redsys.production_url')
            : config('redsys.sandbox_url');
    }

    /**
     * Genera un número de pedido único para Redsys.
     *
     * @param int $pedidoId Identificador interno del pedido
     * @return string Número de pedido de 12 caracteres
     */
    public function createOrderNumber(int $pedidoId): string
    {
        $prefix = str_pad((string) ($pedidoId % 1000000), 6, '0', STR_PAD_LEFT);

        return strtoupper($prefix . Str::random(6));
    }

    /**
     * Construye los datos del formulario de pago Redsys.
     *
     * @param \App\Models\Pedido $pedido Pedido a pagar
     * @param \App\Models\PagoRedsys $pago Registro de pago asociado
     * @return array Datos del formulario (url, parámetros y firma)
     */
    public function buildPaymentForm(Pedido $pedido, PagoRedsys $pago): array
    {
        $parameters = [
            'DS_MERCHANT_ORDER' => $pago->numero_pedido_redsys,
            'DS_MERCHANT_MERCHANTCODE' => config('redsys.merchant_code'),
            'DS_MERCHANT_TERMINAL' => config('redsys.terminal'),
            'DS_MERCHANT_CURRENCY' => config('redsys.currency'),
            'DS_MERCHANT_TRANSACTIONTYPE' => config('redsys.transaction_type'),
            'DS_MERCHANT_AMOUNT' => $this->amountToCents($pedido->total),
            'DS_MERCHANT_MERCHANTURL' => route('redsys.notification'),
            'DS_MERCHANT_URLOK' => route('redsys.ok'),
            'DS_MERCHANT_URLKO' => route('redsys.ko'),
            'DS_MERCHANT_PRODUCTDESCRIPTION' => 'Pedido #' . $pedido->id,
            'DS_MERCHANT_TITULAR' => optional($pedido->usuario)->nombre ?: 'Cliente',
        ];

        $merchantParameters = $this->encodeParameters($parameters);

        return [
            'url' => $this->paymentUrl(),
            'Ds_SignatureVersion' => config('redsys.signature_version'),
            'Ds_MerchantParameters' => $merchantParameters,
            'Ds_Signature' => $this->sign($merchantParameters, $pago->numero_pedido_redsys),
        ];
    }

    /**
     * Decodifica los parámetros de la notificación Redsys desde base64.
     *
     * @param string $merchantParameters Cadena base64url de Redsys
     * @return array Parámetros decodificados
     * @throws \InvalidArgumentException Si los parámetros no son válidos
     */
    public function decodeNotification(string $merchantParameters): array
    {
        $json = base64_decode($this->base64UrlToBase64($merchantParameters), true);

        if ($json === false) {
            throw new InvalidArgumentException('Los parametros de Redsys no son base64 valido.');
        }

        $parameters = json_decode($json, true);

        if (!is_array($parameters)) {
            throw new InvalidArgumentException('Los parametros de Redsys no contienen JSON valido.');
        }

        return $parameters;
    }

    /**
     * Verifica si la firma recibida en la notificación es válida.
     *
     * @param string $merchantParameters Parámetros codificados
     * @param string $receivedSignature Firma recibida de Redsys
     * @param string $order Número de pedido
     * @return bool True si la firma es válida
     */
    public function isValidSignature(string $merchantParameters, string $receivedSignature, string $order): bool
    {
        return hash_equals($this->sign($merchantParameters, $order), $this->normalizeBase64Url($receivedSignature));
    }

    /**
     * Firma los parámetros del merchant usando HMAC-SHA512.
     *
     * @param string $merchantParameters Parámetros codificados en base64url
     * @param string $order Número de pedido para generar la clave de operación
     * @return string Firma en base64url
     */
    public function sign(string $merchantParameters, string $order): string
    {
        $operationKey = $this->createMerchantOperationKey($order);
        $hmac = hash_hmac('sha512', $merchantParameters, $operationKey, true);

        return $this->base64UrlEncode($hmac);
    }

    /**
     * Genera la clave de operación cifrando el número de pedido con AES-128-CBC.
     *
     * @param string $order Número de pedido
     * @return string Clave de operación en base64
     * @throws \RuntimeException Si no se puede cifrar
     */
    public function createMerchantOperationKey(string $order): string
    {
        $key = $this->normalizeSecretKey((string) config('redsys.secret_key'));
        $iv = str_repeat("\0", 16);
        $encrypted = openssl_encrypt($order, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);

        if ($encrypted === false) {
            throw new RuntimeException('No se pudo generar la clave de operacion Redsys.');
        }

        return base64_encode($encrypted);
    }

    /**
     * Convierte un importe decimal a céntimos sin decimales.
     *
     * @param float|string $amount Importe en euros
     * @return string Importe en céntimos
     */
    public function amountToCents($amount): string
    {
        return (string) ((int) round(((float) $amount) * 100));
    }

    /**
     * Determina si un código de respuesta Redsys indica pago exitoso.
     *
     * @param mixed $response Código de respuesta de Redsys
     * @return bool True si el código está entre 0 y 99
     */
    public function isSuccessfulResponse($response): bool
    {
        if ($response === null || !ctype_digit((string) $response)) {
            return false;
        }

        $code = (int) $response;

        return $code >= 0 && $code <= 99;
    }

    /**
     * Codifica los parámetros del merchant a base64url.
     *
     * @param array $parameters Parámetros del formulario
     * @return string Cadena base64url
     */
    private function encodeParameters(array $parameters): string
    {
        return $this->base64UrlEncode(json_encode($parameters, JSON_UNESCAPED_SLASHES));
    }

    /**
     * Normaliza la clave secreta a 16 bytes para AES-128.
     *
     * @param string $key Clave configurada
     * @return string Clave normalizada de 16 caracteres
     */
    private function normalizeSecretKey(string $key): string
    {
        if (strlen($key) > 16) {
            return substr($key, 0, 16);
        }

        return str_pad($key, 16, '0');
    }

    /**
     * Codifica una cadena a base64url (RFC 4648).
     *
     * @param string $value Valor binario a codificar
     * @return string Cadena base64url
     */
    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    /**
     * Normaliza una cadena base64url eliminando padding.
     *
     * @param string $value Valor base64url
     * @return string Valor normalizado
     */
    private function normalizeBase64Url(string $value): string
    {
        return rtrim(strtr($value, '+/', '-_'), '=');
    }

    /**
     * Convierte base64url a base64 estándar añadiendo padding si es necesario.
     *
     * @param string $value Valor base64url
     * @return string Valor base64 estándar
     */
    private function base64UrlToBase64(string $value): string
    {
        $base64 = strtr($value, '-_', '+/');
        $padding = strlen($base64) % 4;

        if ($padding > 0) {
            $base64 .= str_repeat('=', 4 - $padding);
        }

        return $base64;
    }
}
