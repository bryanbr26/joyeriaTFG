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
        Schema::table('CARRITO', function (Blueprint $table) {
            $table->foreign(['id_usuario'], 'CARRITO_ibfk_1')->references(['id'])->on('USUARIO')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_producto'], 'CARRITO_ibfk_2')->references(['id'])->on('PRODUCTO')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('CARRITO', function (Blueprint $table) {
            $table->dropForeign('CARRITO_ibfk_1');
            $table->dropForeign('CARRITO_ibfk_2');
        });
    }
};
