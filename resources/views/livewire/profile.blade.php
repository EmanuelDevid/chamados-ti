<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8 space-y-6">

    <!-- Mensagens de Sucesso -->
    @if (session()->has('profile-success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
            <p>{{ session('profile-success') }}</p>
        </div>
    @endif

    @if (session()->has('password-success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
            <p>{{ session('password-success') }}</p>
        </div>
    @endif

    <!-- Card 1: Informações do Perfil -->
    <div class="bg-white p-6 rounded-lg shadow border border-slate-200">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Perfil do Usuário</h2>
                <p class="text-sm text-slate-500">Seus dados cadastrais no sistema.</p>
            </div>
            @if (!$isEditingProfile)
                <button wire:click="enableEditProfile" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-md transition border border-slate-300">
                    Editar Informações
                </button>
            @endif
        </div>

        @if ($isEditingProfile)
            <form wire:submit="updateProfileInformation" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nome Completo</label>
                    <input type="text" id="name" wire:model="name" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-slate-800">
                    @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Endereço de E-mail</label>
                    <input type="email" id="email" wire:model="email" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-slate-800">
                    @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow transition">
                        Salvar
                    </button>
                    <button type="button" wire:click="cancelEditProfile" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-md transition">
                        Cancelar
                    </button>
                </div>
            </form>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <div class="p-3 bg-slate-50 rounded border border-slate-100">
                    <span class="block text-xs font-semibold text-slate-400 uppercase">Nome</span>
                    <span class="text-slate-800 font-medium">{{ $name }}</span>
                </div>
                <div class="p-3 bg-slate-50 rounded border border-slate-100">
                    <span class="block text-xs font-semibold text-slate-400 uppercase">E-mail</span>
                    <span class="text-slate-800 font-medium">{{ $email }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Card 2: Segurança / Senha -->
    <div class="bg-white p-6 rounded-lg shadow border border-slate-200">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Segurança da Conta</h2>
                <p class="text-sm text-slate-500">Gerencie sua credencial de acesso.</p>
            </div>
            @if (!$isEditingPassword)
                <button wire:click="enableEditPassword" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-md transition border border-slate-300">
                    Alterar Senha
                </button>
            @endif
        </div>

        @if ($isEditingPassword)
            <form wire:submit="updatePassword" class="space-y-4">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1">Senha Atual</label>
                    <input type="password" id="current_password" wire:model="current_password" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-slate-800">
                    @error('current_password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Nova Senha</label>
                    <input type="password" id="password" wire:model="password" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-slate-800">
                    @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirmar Nova Senha</label>
                    <input type="password" id="password_confirmation" wire:model="password_confirmation" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-slate-800">
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow transition">
                        Atualizar Senha
                    </button>
                    <button type="button" wire:click="cancelEditPassword" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-md transition">
                        Cancelar
                    </button>
                </div>
            </form>
        @else
            <div class="p-3 bg-slate-50 rounded border border-slate-100 flex items-center justify-between">
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase">Senha</span>
                    <span class="text-slate-800 font-medium">••••••••••••</span>
                </div>
            </div>
        @endif
    </div>

</div>