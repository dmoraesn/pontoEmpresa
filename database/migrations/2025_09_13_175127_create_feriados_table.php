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
    Schema::create('feriados', function (Blueprint $table) {
        $table->id();
        $table->date('data')->unique();
        $table->string('descricao', 120);
        $table->enum('tipo', ['nacional','estadual','municipal','empresa'])->default('nacional');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feriados');
    }
};
