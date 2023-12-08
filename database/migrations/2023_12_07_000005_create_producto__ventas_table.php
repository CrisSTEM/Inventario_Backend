<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoVentasTable extends Migration
{
    public function up()
    {
        Schema::create('producto_venta', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_venta');
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->foreign('id_venta')->references('id')->on('ventas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('producto_venta');
    }
}
