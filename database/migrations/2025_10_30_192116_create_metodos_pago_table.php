<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('METODOS_PAGO', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('descripcion', 255);
            // SIN timestamps()
        });
    }

    public function down()
    {
        Schema::dropIfExists('METODOS_PAGO');
    }
};