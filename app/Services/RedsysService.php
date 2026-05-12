<?php

namespace App\Services;

use App\Models\PagoRedsys;
use App\Models\Pedido;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

class RedsysService
{
    public function paymentUrl(): string
    {
        return config('redsys.environment') === 'production'
            ? config('redsys.production_url')
            : config('redsys.sandbox_url');
    }

    public function createOrderNumber(int $pedidoId): string
    {
        $prefix = str_pad((string) ($pedidoId % 1000000), 6, '0', STR_PAD_LEFT);

        return strtoupper($prefix . Str::random(6));
    }

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

    public function isValidSignature(string $merchantParameters, string $receivedSignature, string $order): bool
    {
        return hash_equals($this->sign($merchantParameters, $order), $this->normalizeBase64Url($receivedSignature));
    }

    public function sign(string $merchantParameters, string $order): string
    {
        $operationKey = $this->createMerchantOperationKey($order);
        $hmac = hash_hmac('sha512', $merchantParameters, $operationKey, true);

        return $this->base64UrlEncode($hmac);
    }

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

    public function amountToCents($amount): string
    {
        return (string) ((int) round(((float) $amount) * 100));
    }

    public function isSuccessfulResponse($response): bool
    {
        if ($response === null || !ctype_digit((string) $response)) {
            return false;
        }

        $code = (int) $response;

        return $code >= 0 && $code <= 99;
    }

    private function encodeParameters(array $parameters): string
    {
        return $this->base64UrlEncode(json_encode($parameters, JSON_UNESCAPED_SLASHES));
    }

    private function normalizeSecretKey(string $key): string
    {
        if (strlen($key) > 16) {
            return substr($key, 0, 16);
        }

        return str_pad($key, 16, '0');
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    private function normalizeBase64Url(string $value): string
    {
        return rtrim(strtr($value, '+/', '-_'), '=');
    }

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
