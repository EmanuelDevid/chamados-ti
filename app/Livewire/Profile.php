<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class Profile extends Component
{
    public string $name = '';
    public string $email = '';

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Modos de edição
    public bool $isEditingProfile = false;
    public bool $isEditingPassword = false;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function enableEditProfile(): void
    {
        $this->isEditingProfile = true;
    }

    public function cancelEditProfile(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->isEditingProfile = false;
        $this->resetValidation();
    }

    public function enableEditPassword(): void
    {
        $this->isEditingPassword = true;
    }

    public function cancelEditPassword(): void
    {
        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->isEditingPassword = false;
        $this->resetValidation();
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        $this->isEditingProfile = false;
        session()->flash('profile-success', 'Perfil atualizado com sucesso!');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->isEditingPassword = false;

        session()->flash('password-success', 'Senha alterada com sucesso!');
    }

    public function render()
    {
        return view('livewire.profile')->layout('layouts.app');
    }
}