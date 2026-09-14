<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;

class IndexTickets extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $priorityFilter = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingPriorityFilter() { $this->resetPage(); }

    public function render()
    {
        $tickets = Ticket::with(['department', 'type', 'subtype'])
            ->when($this->search, function ($query) {
                $query->where('protocol', 'like', "%{$this->search}%")
                      ->orWhere('subject', 'like', "%{$this->search}%");
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