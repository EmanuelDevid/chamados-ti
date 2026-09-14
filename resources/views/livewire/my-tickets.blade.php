<div class="max-w-7xl mx-auto p-6 my-6">
    {{-- Cabeçalho --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Meus Chamados</h1>
            <p class="text-sm text-slate-500">Acompanhe o andamento das suas solicitações à TI</p>
        </div>
        <div>
            <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-4 py-2 rounded-md shadow transition" wire:navigate>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Abrir Novo Chamado
            </a>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200 mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="w-full md:w-1/2">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por protocolo ou assunto..." class="w-full rounded-md border-slate-300 shadow-sm border p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="w-full md:w-auto">
            <select wire:model.live="statusFilter" class="w-full md:w-auto rounded-md border-slate-300 shadow-sm border p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Todos os Status</option>
                <option value="novo">Novo</option>
                <option value="em_atendimento">Em Atendimento</option>
                <option value="aguardando_usuario">Aguardando Usuário</option>
                <option value="resolvido">Resolvido</option>
                <option value="fechado">Fechado</option>
            </select>
        </div>
    </div>

    {{-- Tabela do Servidor --}}
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 font-semibold border-b border-slate-200 uppercase text-xs">
                    <tr>
                        <th class="p-4">Protocolo</th>
                        <th class="p-4">Assunto</th>
                        <th class="p-4">Tipo de Serviço</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4">Data de Abertura</th>
                        <th class="p-4 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4 font-mono font-bold text-blue-600 whitespace-nowrap">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="hover:underline" wire:navigate>
                                    #{{ $ticket->protocol }}
                                </a>
                            </td>
                            <td class="p-4 font-medium text-slate-900 max-w-xs truncate">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="hover:text-blue-600" wire:navigate>
                                    {{ $ticket->subject }}
                                </a>
                            </td>
                            <td class="p-4">
                                <div class="text-slate-800 font-medium">{{ $ticket->type->name ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-400">{{ $ticket->subtype->name ?? 'N/A' }}</div>
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
                                    Acompanhar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                Você ainda não possui nenhum chamado registrado.
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