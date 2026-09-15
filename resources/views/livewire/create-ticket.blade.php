<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-sm border border-slate-200 mt-6">
    <h2 class="text-2xl font-bold text-slate-800 mb-6 border-b border-slate-200 pb-3">Abrir Novo Chamado - TI</h2>

    @if (session()->has('message'))
    <div class="p-4 mb-6 text-sm text-emerald-800 rounded-lg bg-emerald-50 border border-emerald-200 font-medium flex items-center gap-2">
        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span>{{ session('message') }}</span>
    </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">

        {{-- Setor / Unidade --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Setor / Unidade de Origem *</label>
            <select wire:model="department_id" class="w-full rounded-lg border-slate-300 shadow-sm text-sm p-2.5 bg-white text-slate-700 focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                <option value="">-- Selecione o seu Setor --</option>
                @foreach($departments as $dept)
                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
            @error('department_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        {{-- Selects Encadeados: Tipo e Subtipo --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Tipo de Chamado --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Tipo de Solicitação *</label>
                <select wire:model.live="ticket_type_id" class="w-full rounded-lg border-slate-300 shadow-sm text-sm p-2.5 bg-white text-slate-700 focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                    <option value="">-- Selecione o Tipo --</option>
                    @foreach($ticketTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('ticket_type_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Subtipo de Chamado (Carregado dinamicamente) --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Subtipo / Detalhamento *</label>
                <select wire:model="ticket_subtype_id" {{ empty($subtypes) ? 'disabled' : '' }} class="w-full rounded-lg border-slate-300 shadow-sm text-sm p-2.5 bg-white text-slate-700 focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition {{ empty($subtypes) ? 'bg-slate-100 cursor-not-allowed text-slate-400' : '' }}">
                    <option value="">
                        {{ empty($subtypes) ? '-- Primeiro selecione o tipo --' : '-- Selecione o Subtipo --' }}
                    </option>
                    @foreach($subtypes as $sub)
                    <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </select>
                @error('ticket_subtype_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

        </div>

        {{-- Abrangência (Escopo do problema) --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Qual o alcance do problema? *</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition bg-white">
                    <input type="radio" wire:model="scope" value="individual" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500/20 accent-blue-600 cursor-pointer">
                    <span class="text-sm font-medium text-slate-700">Apenas no meu computador / usuário</span>
                </label>
                <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition bg-white">
                    <input type="radio" wire:model="scope" value="team" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500/20 accent-blue-600 cursor-pointer">
                    <span class="text-sm font-medium text-slate-700">Afeta minha equipe / sala</span>
                </label>
                <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition bg-white">
                    <input type="radio" wire:model="scope" value="sector" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500/20 accent-blue-600 cursor-pointer">
                    <span class="text-sm font-medium text-slate-700">Afeta o setor inteiro / Unidade</span>
                </label>
            </div>
            @error('scope') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        {{-- Assunto --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Assunto / Resumo *</label>
            <input type="text" wire:model="subject" placeholder="Ex: Impressora do cadastro não está imprimindo" class="w-full rounded-lg border-slate-300 shadow-sm text-sm p-2.5 bg-white text-slate-700 focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
            @error('subject') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        {{-- Descrição detalhada --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Descrição detalhada do problema *</label>
            <textarea wire:model="description" rows="4" placeholder="Descreva com detalhes o que está acontecendo..." class="w-full rounded-lg border-slate-300 shadow-sm text-sm p-2.5 bg-white text-slate-700 focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition"></textarea>
            @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        {{-- Anexo de Arquivo / Imagem --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Anexo (opcional - fotos, prints de erro)</label>
            <input type="file" wire:model="attachment" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer">
            @error('attachment') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        {{-- Botão de Submeter --}}
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-6 py-2.5 rounded-lg shadow-sm transition focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <span wire:loading.remove>Enviar Chamado</span>
                <span wire:loading class="inline-flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Enviando...
                </span>
            </button>
        </div>
    </form>
</div>