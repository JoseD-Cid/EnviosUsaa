<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstatusToClientesDestinoTable extends Migration
{
    public function up()
    {
        Schema::table('clientes_destino', function (Blueprint $table) {
            $table->boolean('Estatus')->default(1)->after('Direccion');
        });
    }

    public function down()
    {
        Schema::table('clientes_destino', function (Blueprint $table) {
            $table->dropColumn('Estatus');
        });
    }
}