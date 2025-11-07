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
        Schema::create('IMAGENES_PRODUCTO', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url', 500);
            $table->boolean('principal')->nullable()->default(false);
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
        Schema::dropIfExists('IMAGENES_PRODUCTO');
    }
};
