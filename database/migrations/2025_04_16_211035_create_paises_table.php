<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paises', function (Blueprint $table) {
            $table->integer('CodPais')->primary();
            $table->string('Nombre');
            $table->boolean('Estatus')->default(true);
            $table->boolean('IsDelete')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paises');
    }
};