<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Abrir Novo Chamado - TI</h2>

    @if (session()->has('message'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 font-medium">
        {{ session('message') }}
    </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">

        {{-- Setor / Unidade --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Setor / Unidade de Origem *</label>
            <select wire:model="department_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border">
                <option value="">-- Selecione o seu Setor --</option>
                @foreach($departments as $dept)
                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
            @error('department_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Selects Encadeados: Tipo e Subtipo --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Tipo de Chamado --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo de Solicitação *</label>
                <select wire:model.live="ticket_type_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border">
                    <option value="">-- Selecione o Tipo --</option>
                    @foreach($ticketTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('ticket_type_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Subtipo de Chamado (Carregado dinamicamente) --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Subtipo / Detalhamento *</label>
                <select wire:model="ticket_subtype_id" {{ empty($subtypes) ? 'disabled' : '' }} class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border {{ empty($subtypes) ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                    <option value="">
                        {{ empty($subtypes) ? '-- Primeiro selecione o tipo --' : '-- Selecione o Subtipo --' }}
                    </option>
                    @foreach($subtypes as $sub)
                    <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </select>
                @error('ticket_subtype_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

        </div>

        {{-- Abrangência (Escopo do problema) --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Qual o alcance do problema? *</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <label class="flex items-center p-3 border rounded-md cursor-pointer hover:bg-gray-50">
                    <input type="radio" wire:model="scope" value="individual" class="text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700">Apenas no meu computador / usuário</span>
                </label>
                <label class="flex items-center p-3 border rounded-md cursor-pointer hover:bg-gray-50">
                    <input type="radio" wire:model="scope" value="team" class="text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700">Afeta minha equipe / sala</span>
                </label>
                <label class="flex items-center p-3 border rounded-md cursor-pointer hover:bg-gray-50">
                    <input type="radio" wire:model="scope" value="sector" class="text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700">Afeta o setor inteiro / Unidade</span>
                </label>
            </div>
            @error('scope') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Assunto --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Assunto / Resumo *</label>
            <input type="text" wire:model="subject" placeholder="Ex: Impressora do cadastro não está imprimindo" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border">
            @error('subject') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Descrição detalhada --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Descrição detalhada do problema *</label>
            <textarea wire:model="description" rows="4" placeholder="Descreva com detalhes o que está acontecendo..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border"></textarea>
            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Anexo de Arquivo / Imagem --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Anexo (opcional - fotos, prints de erro)</label>
            <input type="file" wire:model="attachment" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
            @error('attachment') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Botão de Submeter --}}
        <div class="flex justify-end pt-4">
            <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-6 py-2.5 rounded-md shadow transition focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <span wire:loading.remove>Enviar Chamado</span>
                <span wire:loading>Enviando...</span>
            </button>
        </div>
    </form>
</div>