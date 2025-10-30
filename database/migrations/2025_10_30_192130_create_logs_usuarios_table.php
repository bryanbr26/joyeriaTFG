<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('LOGS_USUARIOS', function (Blueprint $table) {
            $table->id();
            $table->string('accion', 255);
            $table->timestamp('fecha_accion')->useCurrent();
            $table->foreignId('id_usuario')->constrained('USUARIO');
        });
    }

    public function down()
    {
        Schema::dropIfExists('LOGS_USUARIOS');
    }
};