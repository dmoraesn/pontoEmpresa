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
    Schema::create('ajustes_marcacao', function (Blueprint $table) {
        $table->id();
        $table->foreignId('marcacao_id')->constrained('marcacoes');
        $table->foreignId('usuario_id')->nullable()->constrained('usuarios');
        $table->dateTime('data_hora_anterior')->nullable();
        $table->dateTime('data_hora_novo')->nullable();
        $table->string('motivo', 250);
        $table->string('feito_por', 120);
        $table->timestamp('feito_em')->useCurrent();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajuste_marcacaos');
    }
};
