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
        Schema::create('egresos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dateEgresos');
            $table->string('descriptionEgresos');
            $table->decimal('montoEgresos');
            $table->string('dataEgresos');
            $table->integer('id_departamento1')->unsigned();
            $table->foreign("id_departamento1")->references('id')->on('comercios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('egresos');
    }
};
