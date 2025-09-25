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
    Schema::table('usuarios', function (Blueprint $table) {
        $table->string('tipo_usuario')->default('funcionario')->after('cargo');
    });
}

public function up(): void
{
    Schema::table('usuarios', function (Blueprint $table) {
        $table->string('tipo_usuario')->default('funcionario')->after('cargo');
    });
}

public function down(): void
{
    Schema::table('usuarios', function (Blueprint $table) {
        $table->dropColumn('tipo_usuario');
    });
}

};
