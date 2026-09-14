<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Ticket;
use App\Models\TicketSubtype;
use App\Models\TicketType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateTicket extends Component
{
    use WithFileUploads;

    // Campos do formulário
    public $department_id = '';
    public $ticket_type_id = '';
    public $ticket_subtype_id = '';
    public $subject = '';
    public $description = '';
    public $scope = 'individual'; // Padrão: individual
    public $attachment;

    // Coleções para renderizar as opções nos selects
    public $departments = [];
    public $ticketTypes = [];
    public $subtypes = [];

    // Regras de validação
    protected function rules()
    {
        return [
            'department_id' => 'required|exists:departments,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'ticket_subtype_id' => 'required|exists:ticket_subtypes,id',
            'subject' => 'required|string|min:5|max:150',
            'description' => 'required|string|min:10',
            'scope' => 'required|in:individual,team,sector',
            'attachment' => 'nullable|file|max:5120', // Máx 5MB
        ];
    }

    public function mount()
    {
        // Carrega os setores e os tipos de chamados no carregamento da tela
        $this->departments = Department::orderBy('name')->get();
        $this->ticketTypes = TicketType::orderBy('name')->get();
    }

    // Hook reativo do Livewire: Executado sempre que 'ticket_type_id' muda
    public function updatedTicketTypeId($value)
    {
        $this->ticket_subtype_id = ''; // Reseta o subtipo selecionado

        if ($value) {
            // Busca os subtipos vinculados ao Tipo selecionado
            $this->subtypes = TicketSubtype::where('ticket_type_id', $value)->orderBy('name')->get();
        } else {
            $this->subtypes = [];
        }
    }

    public function save()
    {
        $this->validate();

        // 1. Obter setor e subtipo para calcular a prioridade
        $department = Department::findOrFail($this->department_id);
        $subtype = TicketSubtype::findOrFail($this->ticket_subtype_id);

        // 2. Cálculo automático da prioridade
        $priority = Ticket::calculatePriority(
            $subtype->weight,
            $this->scope,
            $department->is_critical
        );

        // 3. Upload de anexo (se enviado)
        $attachmentPath = null;
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('attachments', 'public');
        }

        // 4. Gerar número de protocolo padronizado
        $todayPrefix = date('Ymd');
        $lastTicketId = Ticket::max('id') + 1;
        $protocol = $todayPrefix . str_pad($lastTicketId, 6, '0', STR_PAD_LEFT);

        // 5. Salvar o chamado estritamente para o usuário logado
        $ticket = Ticket::create([
            'protocol' => $protocol,
            'user_id' => Auth::id(), // Vincula diretamente ao usuário autenticado
            'department_id' => $this->department_id,
            'ticket_type_id' => $this->ticket_type_id,
            'ticket_subtype_id' => $this->ticket_subtype_id,
            'subject' => $this->subject,
            'description' => $this->description,
            'scope' => $this->scope,
            'priority' => $priority,
            'status' => 'novo',
            'attachment_path' => $attachmentPath,
        ]);

        session()->flash('message', "Chamado enviado com sucesso! Protocolo: {$ticket->protocol}");

        // Redireciona para os chamados do próprio usuário
        return redirect()->route('tickets.my-tickets');
    }

    public function render()
    {
        return view('livewire.create-ticket')->layout('layouts.app');
    }
}
