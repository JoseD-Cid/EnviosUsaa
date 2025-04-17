<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->string('Dni', 20)->primary();
            $table->string('Nombres');
            $table->string('Apellidos');
            $table->string('PrimerTelefono');
            $table->string('SegundoTelefono')->nullable();
            $table->boolean('Estatus')->default(true);
            $table->boolean('IsDelete')->default(false);
            $table->integer('CodMunicipio')->nullable();
            $table->string('Direccion'); 
            $table->foreign('CodMunicipio')->references('CodMunicipio')->on('municipios');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};