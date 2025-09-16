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
    Schema::create('abonos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->constrained('usuarios');
        $table->date('data');
        $table->integer('minutos')->default(0);
        $table->string('motivo', 200);
        $table->enum('tipo', ['abonado', 'atestado', 'banco_de_horas', 'outros'])->default('abonado');
        $table->timestamp('criado_em')->useCurrent();
        $table->index(['usuario_id','data']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonos');
    }
};
