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
            $table->string('ruta_grabado_personalizado', 300)->nullable()->after('id_producto');
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
            $table->dropColumn('ruta_grabado_personalizado');
        });
    }
};
