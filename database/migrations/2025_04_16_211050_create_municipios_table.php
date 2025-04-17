<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->integer('CodMunicipio')->primary();
            $table->string('NomMunicipio');
            $table->boolean('Estatus')->default(true);
            $table->boolean('IsDelete')->default(false);
            $table->integer('CodEstado');
            $table->foreign('CodEstado')->references('CodEstado')->on('estados');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('municipios');
    }
};
