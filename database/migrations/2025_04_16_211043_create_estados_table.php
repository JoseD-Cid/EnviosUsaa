<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->integer('CodEstado')->primary();
            $table->string('NomEstado');
            $table->boolean('Estatus')->default(true);
            $table->boolean('IsDelete')->default(false);
            $table->integer('CodPais');
            $table->foreign('CodPais')->references('CodPais')->on('paises');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};
