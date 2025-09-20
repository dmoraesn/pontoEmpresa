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
    Schema::create('marcacoes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->constrained('usuarios');
        $table->enum('tipo', ['Entrada', 'Saída']);
        $table->dateTime('data_hora');
        $table->enum('origem', ['app', 'ajuste_rh', 'importacao'])->default('app');
        $table->index(['usuario_id', 'data_hora']);
    });
}


    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::dropIfExists('marcacoes');
}

};
