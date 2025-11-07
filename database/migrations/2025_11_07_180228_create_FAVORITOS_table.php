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
        Schema::create('FAVORITOS', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('fecha_agregado')->nullable()->useCurrent();
            $table->unsignedInteger('id_usuario')->nullable()->index('id_usuario');
            $table->unsignedInteger('id_producto')->nullable()->index('id_producto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FAVORITOS');
    }
};
