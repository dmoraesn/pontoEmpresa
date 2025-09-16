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
       Schema::table('abonos', function (Blueprint $table) {
    if (!Schema::hasColumn('abonos', 'tipo')) {
        $table->enum('tipo', ['abonado', 'atestado', 'banco_de_horas', 'outros'])->default('abonado');
    }
    if (!Schema::hasColumn('abonos', 'minutos')) {
        $table->integer('minutos')->default(0);
    }
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abonos', function (Blueprint $table) {
            //
        });
    }
};
