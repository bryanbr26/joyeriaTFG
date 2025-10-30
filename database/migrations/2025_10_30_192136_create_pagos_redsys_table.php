<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('PAGOS_REDSYS', function (Blueprint $table) {
            $table->id();
            $table->decimal('importe', 10, 2);
            $table->string('codigo_autorizacion', 100)->nullable();
            $table->enum('estado', ['pendiente', 'completado', 'error'])->default('pendiente');
            $table->timestamp('fecha')->useCurrent();
            $table->json('respuesta_json')->nullable();
            $table->foreignId('id_pedido')->constrained('PEDIDO');
        });
    }

    public function down()
    {
        Schema::dropIfExists('PAGOS_REDSYS');
    }
};