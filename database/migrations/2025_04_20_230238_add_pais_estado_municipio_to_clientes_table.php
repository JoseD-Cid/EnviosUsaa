<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaisEstadoMunicipioToClientesTable extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Eliminar clave foránea y luego la columna CodMunicipio
            $table->dropForeign(['CodMunicipio']);
            $table->dropColumn('CodMunicipio');
    
            // Agregar nuevas columnas
            $table->integer('PaisID')->nullable();
            $table->integer('EstadoID')->nullable();
            $table->string('Municipio', 255)->nullable();
        });
    }
    

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Si revertimos la migración, eliminamos las columnas agregadas y restauramos CodMunicipio
            $table->dropColumn(['PaisID', 'EstadoID', 'Municipio']);
            $table->integer('CodMunicipio')->nullable(); // Restauramos CodMunicipio
        });
    }
}
