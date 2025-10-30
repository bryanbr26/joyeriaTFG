<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('DETALLES_PEDIDO', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->foreignId('id_pedido')->constrained('PEDIDO');
        });
    }

    public function down()
    {
        Schema::dropIfExists('DETALLES_PEDIDO');
    }
};