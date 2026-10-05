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
    public function up(): void
    {
        Schema::table('PRODUCTO', function (Blueprint $table) {
            $table->boolean('es_grabable')->default(false)->after('ruta_grabado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('PRODUCTO', function (Blueprint $table) {
            $table->dropColumn('es_grabable');
        });
    }
};
