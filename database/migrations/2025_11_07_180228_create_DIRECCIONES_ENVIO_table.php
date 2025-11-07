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
        Schema::create('DIRECCIONES_ENVIO', function (Blueprint $table) {
            $table->increments('id');
            $table->string('direccion');
            $table->string('ciudad', 100);
            $table->string('provincia', 100);
            $table->string('codigo_postal', 10);
            $table->string('pais', 100);
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
        Schema::dropIfExists('DIRECCIONES_ENVIO');
    }
};
