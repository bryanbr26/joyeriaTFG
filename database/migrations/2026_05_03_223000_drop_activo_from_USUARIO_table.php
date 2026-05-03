<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('USUARIO', 'activo')) {
            Schema::table('USUARIO', function (Blueprint $table) {
                $table->dropColumn('activo');
            });
        }
    }

    public function down()
    {
        if (!Schema::hasColumn('USUARIO', 'activo')) {
            Schema::table('USUARIO', function (Blueprint $table) {
                $table->boolean('activo')->nullable()->default(false);
            });
        }
    }
};
