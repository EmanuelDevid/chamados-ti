<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class IndexTickets extends Component
{
    use WithPagination;

    // Captura o status enviado via Query String pela Sidebar (?statusFilter=novo)
    #[Url]
    public $statusFilter = '';

    public $search = '';
    public $priorityFilter = '';

    // Reseta a paginação ao digitar na busca ou alterar o filtro de prioridade
    public function updatingSearch() { $this->resetPage(); }
    public function updatingPriorityFilter() { $this->resetPage(); }

    public function mount()
    {
        // Garante a sincronização do filtro caso o valor venha direto pela URL
        $this->statusFilter = request()->query('statusFilter', $this->statusFilter);
    }

    public function render()
    {
        $tickets = Ticket::with(['department', 'type', 'subtype'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('protocol', 'like', "%{$this->search}%")
                      ->orWhere('subject', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->priorityFilter, function ($query) {
                $query->where('priority', $this->priorityFilter);
            })
            ->orderByRaw("CASE priority 
                WHEN 'critical' THEN 1 
                WHEN 'high' THEN 2 
                WHEN 'medium' THEN 3 
                ELSE 4 END")
            ->latest()
            ->paginate(10);

        return view('livewire.index-tickets', compact('tickets'))->layout('layouts.app');
    }
}