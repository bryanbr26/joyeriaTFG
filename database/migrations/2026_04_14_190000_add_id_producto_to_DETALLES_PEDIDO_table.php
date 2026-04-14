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
        Schema::table('DETALLES_PEDIDO', function (Blueprint $table) {
            $table->unsignedInteger('id_producto')->nullable()->index('dp_id_producto')->after('id_pedido');
            $table->foreign(['id_producto'], 'DETALLES_PEDIDO_ibfk_2')->references(['id'])->on('PRODUCTO')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('DETALLES_PEDIDO', function (Blueprint $table) {
            $table->dropForeign('DETALLES_PEDIDO_ibfk_2');
            $table->dropColumn('id_producto');
        });
    }
};
