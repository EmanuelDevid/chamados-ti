<div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
    {{-- Header --}}
    <div class="bg-slate-900 px-6 py-8 text-center border-b border-slate-800">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-blue-600 text-white font-bold text-xl mb-3 shadow-md">
            TI
        </div>
        <h1 class="text-2xl font-bold text-white tracking-wide">SEDHAS TI</h1>
        <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Helpdesk Municipal</p>
    </div>

    <div class="p-6 sm:p-8">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-slate-800">Criar Nova Conta</h2>
            <p class="text-xs text-slate-500">Informe seus dados para se registrar</p>
        </div>

        <form wire:submit.prevent="register" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nome Completo</label>
                <input type="text" wire:model="name" id="name" required autofocus placeholder="Ex: João da Silva" class="w-full rounded-md border-slate-300 shadow-sm border p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-800">
                @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">E-mail</label>
                <input type="email" wire:model="email" id="email" required placeholder="seu.email@sobral.ce.gov.br" class="w-full rounded-md border-slate-300 shadow-sm border p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-800">
                @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Senha</label>
                <input type="password" wire:model="password" id="password" required placeholder="••••••••" class="w-full rounded-md border-slate-300 shadow-sm border p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-800">
                @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">Confirmar Senha</label>
                <input type="password" wire:model="password_confirmation" id="password_confirmation" required placeholder="••••••••" class="w-full rounded-md border-slate-300 shadow-sm border p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-800">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm py-2.5 px-4 rounded-md shadow transition focus:ring-2 focus:ring-blue-500">
                    Cadastrar
                </button>
            </div>
        </form>

        <div class="mt-6 text-center border-t border-slate-100 pt-4">
            <p class="text-xs text-slate-500">
                Já possui uma conta? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Entrar</a>
            </p>
        </div>
    </div>
</div>