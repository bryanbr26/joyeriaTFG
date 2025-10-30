<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('PEDIDO', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha')->useCurrent();
            $table->enum('estado', ['pendiente', 'preparado', 'enviado', 'entregado', 'cancelado'])->default('pendiente');
            $table->decimal('total', 10, 2);
            $table->foreignId('id_usuario')->constrained('USUARIO');
            $table->foreignId('id_direcciones_envio')->constrained('DIRECCIONES_ENVIO');
            $table->foreignId('id_metodos_pago')->constrained('METODOS_PAGO');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('PEDIDO');
    }
};