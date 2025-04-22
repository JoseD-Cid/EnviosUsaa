<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('envios', function (Blueprint $table) {
            $table->id(); // Esta es la clave primaria
        
            $table->string('cliente_dni', 20); // Asegúrate de que `Dni` sea único en la tabla 'clientes'
            $table->foreign('cliente_dni')->references('Dni')->on('clientes')->onDelete('cascade');
        
            $table->date('fecha_envio');
            $table->string('tracking_number')->unique();
            $table->Integer('destino_pais_id')->nullable();
            $table->Integer('destino_estado_id')->nullable();
            $table->string('ciudad_destino');
            $table->string('direccion_destino');
        
            $table->enum('estatus_envio', ['pendiente', 'en tránsito', 'entregado'])->default('pendiente');
        
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
