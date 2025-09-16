<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');

            $table->integer('carga'); // minutos (armazenamento interno, mas mostramos como horas)
            $table->time('entrada');
            $table->time('saida');
            $table->integer('intervalo')->default(0); // minutos
            $table->date('vigente_desde');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
