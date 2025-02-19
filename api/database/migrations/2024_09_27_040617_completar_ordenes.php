<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('completarOrdenes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_orden')->unsigned();
            $table->foreign("id_orden")->references('id')->on('orden');
            $table->integer('id_empleado')->unsigned();
            $table->foreign("id_empleado")->references('id')->on('empleados');
            $table->integer('id_empleado2')->unsigned();
            $table->foreign("id_empleado2")->references('id')->on('empleados');
            $table->integer('id_productosInternos')->unsigned();
            $table->foreign("id_productosInternos")->references('id')->on('productosInternos');
            $table->integer('id_productosInternos2')->unsigned();
            $table->foreign("id_productosInternos2")->references('id')->on('productosInternos');
            $table->integer('id_productosExternos')->unsigned();
            $table->foreign("id_productosExternos")->references('id')->on('productosExternos');
            $table->integer('id_productosExternos2')->unsigned();
            $table->foreign("id_productosExternos2")->references('id')->on('productosExternos');
            $table->string('noTrapear');
            $table->string('noIngresar');
            $table->string('otraDosis');
            $table->decimal('pago');
            $table->string('requiere1');
            $table->string('requiere2');
            $table->string('requiere3');
            $table->string('requiere4');
            $table->string('facturaOrden');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completarOrdenes');
    }
};