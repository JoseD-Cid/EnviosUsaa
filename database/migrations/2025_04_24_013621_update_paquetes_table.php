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
    Schema::table('paquetes', function (Blueprint $table) {
        // Primero eliminamos la foreign key
        $table->dropForeign(['envio_id']);
        
        // Luego eliminamos las columnas
        $table->dropColumn(['envio_id', 'descripcion', 'peso', 'valor_declarado']);
        
        // Renombramos id a PaqueteId
        $table->renameColumn('id', 'PaqueteId');
        
        // Agregamos las nuevas columnas
        $table->string('NombrePaquete');
        $table->string('dimension');
        $table->decimal('precio', 10, 2);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paquetes', function (Blueprint $table) {
            // Revertir los cambios (en caso de rollback)
            $table->renameColumn('PaqueteId', 'id');
            $table->unsignedBigInteger('envio_id');
            $table->string('descripcion');
            $table->integer('peso');
            $table->integer('valor_declarado');
            
            $table->dropColumn(['NombrePaquete', 'dimension', 'precio']);
            
            // Restaurar la foreign key
            $table->foreign('envio_id')->references('id')->on('envios')->onDelete('cascade');
        });
    }
};
