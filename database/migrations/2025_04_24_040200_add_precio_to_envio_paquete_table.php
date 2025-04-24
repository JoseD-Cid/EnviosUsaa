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
        Schema::table('envio_paquete', function (Blueprint $table) {
            $table->decimal('precio', 10, 2)->nullable()->after('descripcion');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('envio_paquete', function (Blueprint $table) {
            //
        });
    }
};
