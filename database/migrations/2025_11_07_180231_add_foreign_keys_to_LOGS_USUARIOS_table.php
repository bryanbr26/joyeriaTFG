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
        Schema::table('LOGS_USUARIOS', function (Blueprint $table) {
            $table->foreign(['id_usuario'], 'LOGS_USUARIOS_ibfk_1')->references(['id'])->on('USUARIO')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('LOGS_USUARIOS', function (Blueprint $table) {
            $table->dropForeign('LOGS_USUARIOS_ibfk_1');
        });
    }
};
