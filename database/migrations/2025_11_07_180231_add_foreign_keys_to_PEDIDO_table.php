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
        Schema::table('PEDIDO', function (Blueprint $table) {
            $table->foreign(['id_usuario'], 'PEDIDO_ibfk_1')->references(['id'])->on('USUARIO')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_direcciones_envio'], 'PEDIDO_ibfk_2')->references(['id'])->on('DIRECCIONES_ENVIO')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['id_metodos_pago'], 'PEDIDO_ibfk_3')->references(['id'])->on('METODOS_PAGO')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PEDIDO', function (Blueprint $table) {
            $table->dropForeign('PEDIDO_ibfk_1');
            $table->dropForeign('PEDIDO_ibfk_2');
            $table->dropForeign('PEDIDO_ibfk_3');
        });
    }
};
