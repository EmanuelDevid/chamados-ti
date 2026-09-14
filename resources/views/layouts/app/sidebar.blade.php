<aside class="w-64 bg-slate-900 text-slate-200 flex flex-col justify-between min-h-screen border-r border-slate-800">
    <div>
        {{-- Identidade Visual SEDHAS TI --}}
        <div class="p-5 flex items-center gap-3 border-b border-slate-800">
            <div class="bg-blue-600 text-white font-extrabold text-xs px-2.5 py-1.5 rounded-lg tracking-wider flex-shrink-0">
                TI
            </div>
            <div class="overflow-hidden">
                <h2 class="font-bold text-white text-base tracking-wide truncate">SEDHAS TI</h2>
                <p class="text-xs text-slate-400 truncate">Helpdesk Municipal</p>
            </div>
        </div>

        {{-- Navegação --}}
        <nav class="p-4 space-y-1">
            
            {{-- Seção Servidor --}}
            <div class="px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400 my-2">
                Área do Servidor
            </div>

            {{-- Novo Chamado --}}
            <a href="{{ route('tickets.create') }}" wire:navigate
               class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition {{ request()->routeIs('tickets.create') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg width="20" height="20" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="max-width: 20px; max-height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Novo Chamado</span>
            </a>

            {{-- Meus Chamados --}}
            <a href="{{ route('tickets.my-tickets') }}" wire:navigate
               class="flex items-center justify-between px-3 py-2.5 rounded-md text-sm font-medium transition {{ request()->routeIs('tickets.my-tickets') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <div class="flex items-center gap-3 overflow-hidden">
                    <svg width="20" height="20" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="max-width: 20px; max-height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span class="truncate">Meus Chamados</span>
                </div>

                @php
                    $myOpenCount = \App\Models\Ticket::where('user_id', auth()->id())
                        ->whereIn('status', ['novo', 'em_atendimento', 'aguardando_usuario'])
                        ->count();
                @endphp
                @if($myOpenCount > 0)
                    <span class="bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded-full flex-shrink-0">
                        {{ $myOpenCount }}
                    </span>
                @endif
            </a>

            {{-- Seção Gestão TI --}}
            <div class="px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400 mt-6 mb-2">
                Gestão TI
            </div>

            {{-- Fila de Atendimento --}}
            <a href="{{ route('tickets.index') }}" wire:navigate
               class="flex items-center justify-between px-3 py-2.5 rounded-md text-sm font-medium transition {{ (request()->routeIs('tickets.index') || request()->routeIs('tickets.show')) ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <div class="flex items-center gap-3 overflow-hidden">
                    <svg width="20" height="20" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="max-width: 20px; max-height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="truncate">Fila de Atendimento</span>
                </div>

                @php
                    $newTicketsCount = \App\Models\Ticket::whereIn('status', ['novo', 'em_atendimento', 'aguardando_usuario'])->count();
                @endphp
                @if($newTicketsCount > 0)
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse flex-shrink-0">
                        {{ $newTicketsCount }}
                    </span>
                @endif
            </a>

        </nav>
    </div>

    {{-- Perfil do Usuário & Logout --}}
    <div class="p-4 border-t border-slate-800">
        <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white text-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="truncate">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'Usuário' }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email ?? 'servidor@sobral.ce.gov.br' }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                @csrf
                <button type="submit" title="Sair do Sistema" class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-md transition">
                    <svg width="20" height="20" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="max-width: 20px; max-height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>