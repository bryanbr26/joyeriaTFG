<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PEDIDO', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('fecha')->nullable()->useCurrent();
            $table->enum('estado', ['pendiente', 'preparado', 'enviado', 'entregado', 'cancelado'])->nullable()->default('pendiente');
            $table->decimal('total', 10);
            $table->unsignedInteger('id_usuario')->nullable()->index('id_usuario');
            $table->unsignedInteger('id_direcciones_envio')->nullable()->index('id_direcciones_envio');
            $table->unsignedInteger('id_metodos_pago')->nullable()->index('id_metodos_pago');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PEDIDO');
    }
};
