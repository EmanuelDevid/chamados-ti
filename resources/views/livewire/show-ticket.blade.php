<div class="max-w-6xl mx-auto p-6 my-6">
    {{-- Voltar --}}
    <div class="mb-4">
        <a href="{{ route('tickets.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
            &larr; Voltar para a Fila de Atendimento
        </a>
    </div>

    {{-- Alert de Sucesso --}}
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- COLUNA DA ESQUERDA: Detalhes do Chamado --}}
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6 space-y-6 border border-gray-100">
            
            {{-- Cabeçalho --}}
            <div class="border-b pb-4 flex justify-between items-start">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Protocolo</span>
                    <h1 class="text-2xl font-mono font-extrabold text-indigo-600">#{{ $ticket->protocol }}</h1>
                </div>
                <div class="text-right">
                    <span class="text-xs text-gray-500">Aberto em</span>
                    <p class="text-sm font-semibold text-gray-700">{{ $ticket->created_at->format('d/m/Y \à\s H:i') }}</p>
                </div>
            </div>

            {{-- Assunto e Descrição --}}
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $ticket->subject }}</h2>
                <div class="bg-gray-50 p-4 rounded-md border text-gray-700 whitespace-pre-line leading-relaxed">
                    {{ $ticket->description }}
                </div>
            </div>

            {{-- Anexo --}}
            @if($ticket->attachment_path)
                <div class="border-t pt-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Anexo Enviado:</h3>
                    <a href="{{ Storage::url($ticket->attachment_path) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md border transition">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Visualizar / Baixar Anexo
                    </a>
                </div>
            @endif

            {{-- Informações do Solicitante --}}
            <div class="border-t pt-4 grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-xs text-gray-500">Solicitante:</span>
                    <p class="font-semibold text-gray-800">{{ $ticket->user->name ?? 'Servidor' }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-500">Unidade / Setor:</span>
                    <p class="font-semibold text-gray-800">{{ $ticket->department->name }}</p>
                </div>
            </div>
        </div>

        {{-- COLUNA DA DIREITA: Painel de Controle TI --}}
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100 h-fit space-y-6">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Gestão do Atendimento</h3>

            {{-- Classificação --}}
            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-xs text-gray-500">Tipo de Serviço:</span>
                    <p class="font-medium text-gray-800">{{ $ticket->type->name }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-500">Subtipo / Detalhamento:</span>
                    <p class="font-medium text-gray-800">{{ $ticket->subtype->name }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-500">Prioridade Calculada:</span>
                    <div class="mt-1">
                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                            {{ $ticket->priority === 'critical' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $ticket->priority === 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                            {{ $ticket->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $ticket->priority === 'low' ? 'bg-gray-100 text-gray-800' : '' }}">
                            {{ strtoupper($ticket->priority) }}
                        </span>
                    </div>
                </div>
            </div>

            <hr>

            {{-- Formulário para alterar Status --}}
            <form wire:submit="updateStatus" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status Atual</label>
                    <select wire:model="status" class="w-full rounded-md border-gray-300 shadow-sm border p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="novo">Novo</option>
                        <option value="em_atendimento">Em Atendimento</option>
                        <option value="aguardando_usuario">Aguardando Usuário</option>
                        <option value="resolvido">Resolvido</option>
                        <option value="fechado">Fechado</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow text-sm transition">
                    Atualizar Status
                </button>
            </form>
        </div>

    </div>
</div>