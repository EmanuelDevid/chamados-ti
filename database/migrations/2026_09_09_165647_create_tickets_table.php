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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('protocol')->unique(); // ex: 20260909000001
            
            // Chaves Estrangeiras
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Solicitante
            $table->foreignId('department_id')->constrained(); // Setor de origem do chamado
            $table->foreignId('ticket_type_id')->constrained();
            $table->foreignId('ticket_subtype_id')->constrained();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete(); // Técnico responsável
            
            // Conteúdo
            $table->string('subject'); // Assunto do Chamado
            $table->text('description'); // Detalhamento
            
            // Regras de Negócio e Priorização
            $table->string('scope')->default('individual'); // individual, team, sector
            $table->string('priority')->default('low'); // low, medium, high, critical
            $table->string('status')->default('novo'); // novo, aberto, pendente, resolvido, fechado
            
            // Anexos e Datas
            $table->string('attachment_path')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
