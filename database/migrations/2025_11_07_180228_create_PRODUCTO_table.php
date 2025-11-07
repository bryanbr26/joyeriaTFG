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
        Schema::create('PRODUCTO', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 200);
            $table->string('descripcion');
            $table->decimal('precio', 10);
            $table->string('material', 100)->nullable();
            $table->decimal('peso')->nullable();
            $table->integer('stock');
            $table->unsignedInteger('id_categoria')->nullable()->index('id_categoria');
            $table->unsignedInteger('id_detalles_pedido')->nullable()->index('id_detalles_pedido');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PRODUCTO');
    }
};
