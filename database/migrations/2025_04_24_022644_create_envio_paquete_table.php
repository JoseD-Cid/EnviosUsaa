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
        Schema::create('envio_paquete', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('envio_id');
            $table->unsignedBigInteger('paquete_id');
            $table->text('descripcion')->nullable();
            $table->timestamps();
            
            $table->foreign('envio_id')->references('id')->on('envios')->onDelete('cascade');
            $table->foreign('paquete_id')->references('PaqueteId')->on('paquetes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envio_paquete');
    }
};