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
        Schema::create('LOGS_USUARIOS', function (Blueprint $table) {
            $table->increments('id');
            $table->string('accion');
            $table->timestamp('fecha_accion')->nullable()->useCurrent();
            $table->unsignedInteger('id_usuario')->nullable()->index('id_usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LOGS_USUARIOS');
    }
};
