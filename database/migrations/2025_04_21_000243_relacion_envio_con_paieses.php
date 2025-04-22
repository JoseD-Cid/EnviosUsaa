<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('envios', function (Blueprint $table) {
        // Agregar claves foráneas
        $table->foreign('destino_pais_id')->references('CodPais')->on('paises')->onDelete('cascade');
        $table->foreign('destino_estado_id')->references('CodEstado')->on('estados')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('envios', function (Blueprint $table) {
            // Eliminar claves foráneas
            $table->dropForeign(['destino_pais_id']);
            $table->dropForeign(['destino_estado_id']);
        });
    }
    
};
