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
        Schema::create('PRODUCTO', function (Blueprint $table) {
            $table->increments('id');
            //Categoria del producto
            $table->enum('categoria', ['anillo', 'pulsera', 'pendiente', 'collar']);

            $table->string('nombre');
            $table->string('marca');
            $table->string('descripcion');
            $table->decimal('precio', 10, 2);
            $table->string('genero');
            $table->string('color');
            $table->string('talla')->nullable();
            $table->string('ruta_grabado', 300);
            $table->string('material')->nullable();
            $table->timestamp('fecha_agregado')->nullable()->useCurrent();
            $table->decimal('peso')->nullable();
            $table->integer('stock');
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
