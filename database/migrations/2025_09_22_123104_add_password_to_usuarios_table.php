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
            if (!Schema::hasColumn('usuarios', 'password')) {
                $table->string('password')->after('email'); // adiciona a coluna password
            }
            if (!Schema::hasColumn('usuarios', 'remember_token')) {
                $table->rememberToken()->after('password'); // opcional: usado pelo Sanctum
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            if (Schema::hasColumn('usuarios', 'password')) {
                $table->dropColumn('password');
            }
            if (Schema::hasColumn('usuarios', 'remember_token')) {
                $table->dropColumn('remember_token');
            }
        });
    }
};
