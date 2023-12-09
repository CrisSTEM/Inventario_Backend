<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 250);
            $table->string('rif', 250);
            $table->string('direccion', 50);
            $table->string('telefono', 50);
            $table->string('vendedor', 250);
            // Agregar la clave foránea que referencia a la tabla 'usuarios'
            $table->unsignedBigInteger('usuario_id'); // asumiendo que 'id' es la clave primaria de 'usuarios'
            $table->foreign('usuario_id')->references('id')->on('usuarios');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
