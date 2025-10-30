<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('CARRITO', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->timestamp('fecha_agregado')->useCurrent();
            $table->foreignId('id_usuario')->constrained('USUARIO');
            $table->foreignId('id_producto')->constrained('PRODUCTO');
        });
    }

    public function down()
    {
        Schema::dropIfExists('CARRITO');
    }
};