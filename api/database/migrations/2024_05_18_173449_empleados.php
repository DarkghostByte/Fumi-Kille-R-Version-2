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
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nameEmpleado');
            $table->string('lastnameEmpleado1');
            $table->string('lastnameEmpleado2');
            $table->string('ariasEmpleado');
            $table->string('infodelete_Empleados');
            $table->integer('id_departamento')->unsigned();
            $table->foreign("id_departamento")->references('id')->on('comercios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
