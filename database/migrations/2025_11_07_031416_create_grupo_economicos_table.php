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
        // Este é o único bloco 'Schema::create' que deve estar aqui.
        Schema::create('grupo_economicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps(); // Cria 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_economicos');
    }
};
