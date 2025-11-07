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
        Schema::table('IMAGENES_PRODUCTO', function (Blueprint $table) {
            $table->foreign(['id_producto'], 'IMAGENES_PRODUCTO_ibfk_1')->references(['id'])->on('PRODUCTO')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('IMAGENES_PRODUCTO', function (Blueprint $table) {
            $table->dropForeign('IMAGENES_PRODUCTO_ibfk_1');
        });
    }
};
