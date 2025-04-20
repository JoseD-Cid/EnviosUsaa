<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paquetes', function (Blueprint $table) {
            $table->id(); // Clave primaria para paquetes

            $table->unsignedBigInteger('envio_id');
            $table->foreign('envio_id')->references('id')->on('envios')->onDelete('cascade'); // Relación con la tabla envios

            $table->string('descripcion');
            $table->integer('peso'); // en gramos
            $table->integer('valor_declarado'); // en USD o Lempiras

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};
