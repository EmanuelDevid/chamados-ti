<div class="min-h-screen bg-slate-100 p-4 md:p-8 text-slate-800">
    <div class="max-w-7xl mx-auto space-y-6">

        @if (session()->has('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Cabeçalho Integrado --}}
        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xs font-mono font-bold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md border border-slate-200">
                        #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full 
                        {{ $ticket->status === 'novo' ? 'bg-amber-100 text-amber-800 border border-amber-200' : '' }}
                        {{ $ticket->status === 'em_atendimento' ? 'bg-blue-100 text-blue-800 border border-blue-200' : '' }}
                        {{ $ticket->status === 'aguardando_usuario' ? 'bg-purple-100 text-purple-800 border border-purple-200' : '' }}
                        {{ $ticket->status === 'concluido' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : '' }}
                        {{ $ticket->status === 'cancelado' ? 'bg-rose-100 text-rose-800 border border-rose-200' : '' }}">
                        {{ $this->getStatusLabel($ticket->status) }}
                    </span>
                    <span class="text-xs text-slate-500">
                        Criado em {{ $ticket->created_at->format('d/m/Y \à\s H:i') }}
                    </span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $ticket->subject ?? $ticket->title ?? 'Atendimento de Suporte' }}</h1>
            </div>

            {{-- Controle de Status --}}
            <div class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-xl border border-slate-200">
                <select wire:model="newStatus" class="bg-white border border-slate-300 text-slate-700 text-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none shadow-sm">
                    <option value="novo">Novo</option>
                    <option value="em_atendimento">Em Atendimento</option>
                    <option value="aguardando_usuario">Aguardando Usuário</option>
                    <option value="concluido">Concluído</option>
                    <option value="cancelado">Cancelado</option>
                </select>
                <button wire:click="updateStatus" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition shadow-sm">
                    Atualizar Status
                </button>
            </div>
        </div>

        {{-- Grid Principal --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- Coluna Esquerda: Linha do Tempo e Conversa (2/3) --}}
            <div class="lg:col-span-2 bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
                
                {{-- Seção: Descrição Inicial do Chamado --}}
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm border border-blue-200">
                            {{ strtoupper(substr($ticket->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $ticket->user->name ?? 'Servidor' }}</p>
                            <p class="text-xs text-slate-500">Solicitação inicial</p>
                        </div>
                    </div>
                    <div class="text-slate-700 text-sm leading-relaxed bg-white p-4 rounded-xl border border-slate-200 shadow-2xs whitespace-pre-line">
                        {{ $ticket->description }}
                    </div>
                </div>

                {{-- Seção: Timeline e Chat --}}
                <div class="p-6 space-y-6">
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Histórico & Mensagens
                    </h2>

                    <div class="space-y-4">
                        @forelse($messages as $msg)
                            @if($msg->is_system_log)
                                {{-- Evento de Sistema --}}
                                <div class="flex items-center justify-center my-3">
                                    <span class="bg-slate-100 text-slate-600 border border-slate-200 text-xs px-3 py-1 rounded-full flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <strong class="text-slate-800">{{ $msg->user->name ?? 'Sistema' }}</strong> {{ $msg->message }}
                                        <span class="text-slate-400">• {{ $msg->created_at->format('H:i') }}</span>
                                    </span>
                                </div>
                            @else
                                {{-- Balão de Mensagem --}}
                                <div class="flex gap-3 {{ $msg->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                                    <div class="w-8 h-8 rounded-full {{ $msg->user_id === auth()->id() ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-700' }} flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-2xs">
                                        {{ strtoupper(substr($msg->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="max-w-[80%]">
                                        <div class="flex items-center gap-2 mb-1 {{ $msg->user_id === auth()->id() ? 'justify-end' : '' }}">
                                            <span class="text-xs font-semibold text-slate-700">{{ $msg->user->name }}</span>
                                            <span class="text-[10px] text-slate-400">{{ $msg->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <div class="p-3.5 rounded-2xl text-sm leading-relaxed {{ $msg->user_id === auth()->id() ? 'bg-blue-600 text-white rounded-tr-none shadow-sm' : 'bg-slate-100 text-slate-800 rounded-tl-none border border-slate-200' }}">
                                            {{ $msg->message }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-center text-xs text-slate-400 py-4">Nenhuma mensagem registrada até o momento.</p>
                        @endforelse
                    </div>

                    {{-- Form de Envio --}}
                    <form wire:submit.prevent="sendMessage" class="pt-4 border-t border-slate-100 space-y-3">
                        <textarea wire:model="newMessage" rows="3" placeholder="Escreva uma resposta ou atualização..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent outline-none resize-none placeholder-slate-400 transition"></textarea>
                        @error('newMessage') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-5 py-2 rounded-xl transition flex items-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Enviar Resposta
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Coluna Direita: Informações do Solicitante (1/3) --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">
                    Detalhes do Solicitante
                </h3>

                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-xs text-slate-400 mb-0.5">Nome do Servidor</p>
                        <p class="font-semibold text-slate-800">{{ $ticket->user->name ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-0.5">E-mail Institucional</p>
                        <p class="font-mono text-xs text-slate-600 break-all bg-slate-50 p-2 rounded-lg border border-slate-100">{{ $ticket->user->email ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-0.5">Setor / Órgão</p>
                        <p class="font-medium text-slate-700">{{ $ticket->sector ?? 'SEDHAS / CRAS' }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>