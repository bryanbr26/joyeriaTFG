<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('DIRECCIONES_ENVIO', function (Blueprint $table) {
            $table->id();
            $table->string('direccion', 255);
            $table->string('ciudad', 100);
            $table->string('provincia', 100);
            $table->string('codigo_postal', 10);
            $table->string('pais', 100);
            $table->foreignId('id_usuario')->constrained('USUARIO');
            // SIN timestamps()
        });
    }

    public function down()
    {
        Schema::dropIfExists('DIRECCIONES_ENVIO');
    }
};