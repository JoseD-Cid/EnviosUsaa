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
        Schema::create('clientes_destino', function (Blueprint $table) {
            $table->string('Dni')->primary();
            $table->string('Nombres');
            $table->string('Apellidos');
            $table->string('Telefono')->nullable();
            $table->string('Email')->nullable();
            $table->integer('CodPais');
            $table->integer('CodEstado');
            $table->string('Ciudad');
            $table->string('Direccion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
