<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('PAGOS_REDSYS', function (Blueprint $table) {
            $table->string('numero_pedido_redsys', 12)->nullable()->unique()->after('id');
        });
    }

    public function down()
    {
        Schema::table('PAGOS_REDSYS', function (Blueprint $table) {
            $table->dropUnique(['numero_pedido_redsys']);
            $table->dropColumn('numero_pedido_redsys');
        });
    }
};
