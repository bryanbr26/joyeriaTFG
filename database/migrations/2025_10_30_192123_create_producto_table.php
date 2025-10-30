<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('PRODUCTO', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->string('descripcion', 255);
            $table->decimal('precio', 10, 2);
            $table->string('material', 100)->nullable();
            $table->decimal('peso', 8, 2)->nullable();
            $table->integer('stock');
            $table->foreignId('id_categoria')->constrained('CATEGORIA');
            $table->foreignId('id_detalles_pedido')->nullable()->constrained('DETALLES_PEDIDO');
        });
    }

    public function down()
    {
        Schema::dropIfExists('PRODUCTO');
    }
};