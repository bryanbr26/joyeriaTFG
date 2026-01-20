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
        Schema::create('USUARIO', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->enum('rol', ['user', 'admin']);
            $table->string('apellidos', 150);
            $table->string('email')->unique('email');
            $table->string('password');
            $table->string('telefono', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('fecha_registro')->nullable()->useCurrent();
            $table->boolean('activo')->nullable()->default(false);
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('USUARIO');
    }
};
