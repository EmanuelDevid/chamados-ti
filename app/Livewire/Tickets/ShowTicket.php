<?php

namespace App\Livewire\Tickets;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Livewire\Component;

class ShowTicket extends Component
{
    public Ticket $ticket;
    public string $newMessage = '';
    public string $newStatus = '';

    public function mount(Ticket $ticket)
    {
        // Verifica se o usuário logado É o criador do chamado OU se é Admin/TI
        // Altere 'is_admin' pelo campo correto do seu banco de dados (ex: role === 'admin')
        if ($ticket->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Acesso não autorizado a este chamado.');
        }

        $this->ticket = $ticket;
        $this->newStatus = $ticket->status;
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|min:2',
        ]);

        $this->ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $this->newMessage,
            'is_system_log' => false,
        ]);

        $this->newMessage = '';
        $this->ticket->refresh();
    }

    public function updateStatus()
    {
        if ($this->newStatus === $this->ticket->status) {
            return;
        }

        $oldStatus = $this->getStatusLabel($this->ticket->status);
        $this->ticket->status = $this->newStatus;
        $this->ticket->save();

        $newStatusLabel = $this->getStatusLabel($this->newStatus);

        $this->ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => "Alterou o status do chamado de '{$oldStatus}' para '{$newStatusLabel}'.",
            'is_system_log' => true,
        ]);

        $this->ticket->refresh();
        session()->flash('success', 'Status atualizado com sucesso!');
    }

    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'novo' => 'Novo',
            'em_atendimento' => 'Em Atendimento',
            'aguardando_usuario' => 'Aguardando Usuário',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado',
            default => $status,
        };
    }

    public function render()
    {
        return view('livewire.show-ticket', [
            'messages' => $this->ticket->messages()->with('user')->get(),
        ])->layout('layouts.app');
    }
}
