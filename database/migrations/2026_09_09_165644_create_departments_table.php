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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ex: CRAS, Almoxarifado, Recepção, TI
            $table->string('code')->nullable(); // ex: CRAS-CENTRO, ALMOX
            $table->boolean('is_critical')->default(false); // Ajuda na pontuação da prioridade
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
