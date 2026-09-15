<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'protocol',
        'user_id',
        'department_id',
        'ticket_type_id',
        'ticket_subtype_id',
        'assigned_to',
        'subject',
        'description',
        'scope',
        'priority',
        'status',
        'attachment_path',
        'resolved_at',
    ];

    // Relacionamentos
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }

    public function subtype(): BelongsTo
    {
        return $this->belongsTo(TicketSubtype::class, 'ticket_subtype_id');
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(TicketInteraction::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class)->oldest();
    }

    // Regra de Cálculo de Prioridade Automática
    public static function calculatePriority(int $subtypeWeight, string $scope, bool $isCriticalDepartment): string
    {
        $scopeWeight = match ($scope) {
            'sector' => 3,
            'team' => 2,
            default => 1, // individual
        };

        $score = $subtypeWeight + $scopeWeight + ($isCriticalDepartment ? 1 : 0);

        return match (true) {
            $score >= 7 => 'critical', // Crítico
            $score >= 5 => 'high',     // Alta
            $score >= 3 => 'medium',   // Média
            default => 'low',          // Baixa
        };
    }
}
