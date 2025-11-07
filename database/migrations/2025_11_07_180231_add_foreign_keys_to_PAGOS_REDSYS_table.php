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
        Schema::table('PAGOS_REDSYS', function (Blueprint $table) {
            $table->foreign(['id_pedido'], 'PAGOS_REDSYS_ibfk_1')->references(['id'])->on('PEDIDO')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PAGOS_REDSYS', function (Blueprint $table) {
            $table->dropForeign('PAGOS_REDSYS_ibfk_1');
        });
    }
};
