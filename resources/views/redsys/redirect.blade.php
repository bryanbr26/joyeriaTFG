@extends("layouts.layout")

@section("title", "Redirigiendo al pago")

@section("content")

<div class="container py-5 text-center" style="min-height: 60vh;">
    <div class="mx-auto bg-white border p-5" style="max-width: 560px;">
        <h2 class="text-dark mb-3" style="font-family: 'Italiana', serif;">Pago seguro</h2>
        <p class="text-muted mb-4">
            Te estamos redirigiendo al TPV Virtual de Redsys para finalizar el pago.
        </p>

        <form id="redsys-payment-form" action="{{ $formData['url'] }}" method="POST">
            <input type="hidden" name="Ds_SignatureVersion" value="{{ $formData['Ds_SignatureVersion'] }}">
            <input type="hidden" name="Ds_MerchantParameters" value="{{ $formData['Ds_MerchantParameters'] }}">
            <input type="hidden" name="Ds_Signature" value="{{ $formData['Ds_Signature'] }}">

            <button type="submit" class="btn btn-dark btn-lg px-5 rounded-0">
                <i class="bi bi-shield-lock me-2"></i>Continuar al pago
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('redsys-payment-form').submit();
    });
</script>

@endsection
