<div class="max-w-7xl mx-auto p-6 my-6">
    {{-- Cabeçalho da Página --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Fila de Atendimento - Chamados</h1>
            <p class="text-sm text-slate-500">Gerencie e acompanhe as solicitações da SEDHAS TI</p>
        </div>
        <div>
            <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-4 py-2 rounded-md shadow transition" wire:navigate>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Novo Chamado
            </a>
        </div>
    </div>

    {{-- Filtros e Busca --}}
    <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200 mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="w-full md:w-1/3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por protocolo ou assunto..." class="w-full rounded-md border-slate-300 shadow-sm border p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <select wire:model.live="statusFilter" class="rounded-md border-slate-300 shadow-sm border p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Todos os Status</option>
                <option value="novo">Novo</option>
                <option value="em_atendimento">Em Atendimento</option>
                <option value="aguardando_usuario">Aguardando Usuário</option>
                <option value="resolvido">Resolvido</option>
                <option value="fechado">Fechado</option>
            </select>
            <select wire:model.live="priorityFilter" class="rounded-md border-slate-300 shadow-sm border p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Todas as Prioridades</option>
                <option value="critical">Crítico</option>
                <option value="high">Alta</option>
                <option value="medium">Média</option>
                <option value="low">Baixa</option>
            </select>
        </div>
    </div>

    {{-- Tabela de Chamados --}}
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 font-semibold border-b border-slate-200 uppercase text-xs">
                    <tr>
                        <th class="p-4">Protocolo</th>
                        <th class="p-4">Assunto</th>
                        <th class="p-4">Solicitante / Setor</th>
                        <th class="p-4">Tipo</th>
                        <th class="p-4 text-center">Prioridade</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4">Data</th>
                        <th class="p-4 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4 font-mono font-bold text-blue-600 whitespace-nowrap">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="hover:underline flex items-center gap-1" wire:navigate>
                                    #{{ $ticket->protocol }}
                                </a>
                            </td>
                            <td class="p-4 font-medium text-slate-900 max-w-xs truncate">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="hover:text-blue-600" wire:navigate>
                                    {{ $ticket->subject }}
                                </a>
                            </td>
                            <td class="p-4">
                                <div class="font-medium text-slate-800">{{ $ticket->user->name ?? 'Servidor' }}</div>
                                <div class="text-xs text-slate-400">{{ $ticket->department->name ?? 'N/A' }}</div>
                            </td>
                            <td class="p-4">
                                <div class="text-slate-800 font-medium">{{ $ticket->type->name ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-400">{{ $ticket->subtype->name ?? 'N/A' }}</div>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $ticket->priority === 'critical' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $ticket->priority === 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $ticket->priority === 'medium' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $ticket->priority === 'low' ? 'bg-slate-100 text-slate-800' : '' }}">
                                    {{ strtoupper($ticket->priority) }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $ticket->status === 'novo' ? 'bg-sky-100 text-sky-800' : '' }}
                                    {{ $ticket->status === 'em_atendimento' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $ticket->status === 'aguardando_usuario' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $ticket->status === 'resolvido' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $ticket->status === 'fechado' ? 'bg-slate-100 text-slate-600' : '' }}">
                                    {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                                </span>
                            </td>
                            <td class="p-4 text-xs text-slate-500 whitespace-nowrap">
                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold rounded-md border border-blue-200 transition" wire:navigate>
                                    Ver Detalhes
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-500">
                                Nenhum chamado encontrado na fila.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($tickets, 'hasPages') && $tickets->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
</div>