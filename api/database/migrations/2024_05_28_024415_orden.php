ñ<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orden', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cliente')->unsigned();
            $table->foreign("id_cliente")->references('id')->on('clientes');
            $table->integer('id_plague1')->unsigned();
            $table->foreign("id_plague1")->references('id')->on('problematicas');
            $table->integer('id_plague2')->unsigned();
            $table->foreign("id_plague2")->references('id')->on('problematicas');
            $table->string('date1');
            $table->string('date2');
            $table->string('time1');
            $table->string('time2');
            $table->string('hiring');
            $table->string('infoorden_delete');
            $table->string('infoorden_certificate');
            $table->string('infoorden_remision');
            $table->string('infoorden_facturacion');
            $table->string('infoorden_cell');
            $table->string('statusOrder');
            $table->string('nDosis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden');
    }
};