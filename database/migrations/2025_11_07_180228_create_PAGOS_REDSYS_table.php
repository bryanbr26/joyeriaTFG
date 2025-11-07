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
        Schema::create('PAGOS_REDSYS', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('importe', 10);
            $table->string('codigo_autorizacion', 100)->nullable();
            $table->enum('estado', ['pendiente', 'completado', 'error'])->nullable()->default('pendiente');
            $table->timestamp('fecha')->nullable()->useCurrent();
            $table->json('respuesta_json')->nullable();
            $table->unsignedInteger('id_pedido')->nullable()->index('id_pedido');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PAGOS_REDSYS');
    }
};
