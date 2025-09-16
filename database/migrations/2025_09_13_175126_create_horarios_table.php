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
    Schema::create('horarios', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->constrained('usuarios');
        $table->integer('carga_diaria_minutos')->default(480);
        $table->time('hora_entrada_prevista')->default('08:00:00');
        $table->time('hora_saida_prevista')->default('17:00:00');
        $table->integer('intervalo_minimo_minutos')->default(60);
        $table->date('vigente_desde')->default(DB::raw('CURRENT_DATE'));
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
