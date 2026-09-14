<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\CreateTicket;
use App\Livewire\IndexTickets;
use App\Livewire\MyTickets;
use App\Livewire\ShowTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('tickets.index');
    });

    Route::get('/dashboard', function () {
        return redirect()->route('tickets.index');
    })->name('dashboard');

    Route::get('/tickets', IndexTickets::class)->name('tickets.index');
    Route::get('/tickets/create', CreateTicket::class)->name('tickets.create');
    Route::get('/tickets/{ticket}', ShowTicket::class)->name('tickets.show');
    Route::get('/my-tickets', MyTickets::class)->name('tickets.my-tickets');

    Route::get('/profile', function () {
        return response('Perfil em desenvolvimento');
    })->name('profile.edit');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});