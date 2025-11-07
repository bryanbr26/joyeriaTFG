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
        Schema::table('PRODUCTO', function (Blueprint $table) {
            $table->foreign(['id_categoria'], 'PRODUCTO_ibfk_1')->references(['id'])->on('CATEGORIA')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['id_detalles_pedido'], 'PRODUCTO_ibfk_2')->references(['id'])->on('DETALLES_PEDIDO')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PRODUCTO', function (Blueprint $table) {
            $table->dropForeign('PRODUCTO_ibfk_1');
            $table->dropForeign('PRODUCTO_ibfk_2');
        });
    }
};
