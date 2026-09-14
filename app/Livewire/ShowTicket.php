<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class ShowTicket extends Component
{
    public Ticket $ticket;

    // Campos manipulados pela TI
    public $status;

    public function mount(Ticket $ticket)
    {
        // Carrega o chamado com todos os seus relacionamentos
        $this->ticket = $ticket->load(['department', 'type', 'subtype', 'user']);
        $this->status = $ticket->status;
    }

    public function updateStatus()
    {
        $this->validate([
            'status' => 'required|in:novo,em_atendimento,aguardando_usuario,resolvido,fechado',
        ]);

        $this->ticket->update([
            'status' => $this->status,
        ]);

        session()->flash('message', 'Status do chamado atualizado com sucesso!');
    }

    public function render()
    {
        return view('livewire.show-ticket')->layout('layouts.app');
    }
}