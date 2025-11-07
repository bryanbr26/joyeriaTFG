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
        Schema::table('DIRECCIONES_ENVIO', function (Blueprint $table) {
            $table->foreign(['id_usuario'], 'DIRECCIONES_ENVIO_ibfk_1')->references(['id'])->on('USUARIO')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('DIRECCIONES_ENVIO', function (Blueprint $table) {
            $table->dropForeign('DIRECCIONES_ENVIO_ibfk_1');
        });
    }
};
