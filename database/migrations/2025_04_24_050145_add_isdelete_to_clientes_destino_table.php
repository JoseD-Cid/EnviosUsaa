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
        Schema::table('clientes_destino', function (Blueprint $table) {
            $table->boolean('IsDelete')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('clientes_destino', function (Blueprint $table) {
            $table->dropColumn('IsDelete');
        });
    }
    
};
