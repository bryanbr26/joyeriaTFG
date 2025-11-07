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
        Schema::table('FAVORITOS', function (Blueprint $table) {
            $table->foreign(['id_usuario'], 'FAVORITOS_ibfk_1')->references(['id'])->on('USUARIO')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['id_producto'], 'FAVORITOS_ibfk_2')->references(['id'])->on('PRODUCTO')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('FAVORITOS', function (Blueprint $table) {
            $table->dropForeign('FAVORITOS_ibfk_1');
            $table->dropForeign('FAVORITOS_ibfk_2');
        });
    }
};
