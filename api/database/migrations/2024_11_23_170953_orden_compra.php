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
        Schema::create('ordenCompra', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fechaOrdenCompra');
            $table->string('paraOrdenCompra');
            $table->string('conceptoOrdenCompra');
            $table->string('detalleOrdenCompra');
            $table->string('empleadoOrdenCompra');
            $table->string('importeOrdenCompra');
            $table->string('autorizoOrdenCompra');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenCompra');
    }
};