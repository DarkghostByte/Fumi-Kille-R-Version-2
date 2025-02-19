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
        Schema::create('certificados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_orden')->unsigned();
            $table->foreign("id_orden")->references('id')->on('orden');
            $table->string('certificateName');
            $table->integer('id_productoCertificadoInt1')->unsigned();
            $table->foreign("id_productoCertificadoInt1")->references('id')->on('productosInternos');
            $table->integer('id_productoCertificadoExt1')->unsigned();
            $table->foreign("id_productoCertificadoExt1")->references('id')->on('productosExternos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');    }
};
