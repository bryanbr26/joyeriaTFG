<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('USUARIO', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellidos', 150);
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->string('telefono', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
            $table->boolean('activo')->default(false);
            $table->rememberToken();
        });
    }

    public function down()
    {
        Schema::dropIfExists('USUARIO');
    }
};