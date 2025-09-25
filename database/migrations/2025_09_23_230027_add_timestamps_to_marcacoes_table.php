<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('marcacoes', function (Blueprint $table) {
        $table->timestamps(); // adiciona created_at e updated_at
    });
}

public function down()
{
    Schema::table('marcacoes', function (Blueprint $table) {
        $table->dropTimestamps();
    });
}

};
