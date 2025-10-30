<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('IMAGENES_PRODUCTO', function (Blueprint $table) {
            $table->id();
            $table->string('url', 500);
            $table->boolean('principal')->default(false);
            $table->foreignId('id_producto')->constrained('PRODUCTO');
        });
    }

    public function down()
    {
        Schema::dropIfExists('IMAGENES_PRODUCTO');
    }
};