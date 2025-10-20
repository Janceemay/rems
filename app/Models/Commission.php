<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Commission extends Model
{
    use HasFactory;

    protected $primaryKey = 'commission_id';
    protected $fillable = [
        'transaction_id',
        'agent_id',
        'percentage',
        'amount',
        'approval_status',
        'approved_by',
        'date_generated',
        'remarks'
    ];

    protected $dates = ['date_generated'];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id', 'user_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'user_id');
    }

    public function getComputedAmountAttribute()
    {
        if ($this->transaction && $this->percentage) {
            return ($this->transaction->total_amount ?? 0) * ($this->percentage / 100);
        }
        return 0;
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->approval_status) {
            'pending' => 'Pending Approval',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'on_hold' => 'On Hold',
            default => ucfirst($this->approval_status ?? 'Pending'),
        };
    }

    public function isApproved(): bool
    {
        return $this->approval_status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->approval_status === 'pending';
    }

    public function getFormattedDateGeneratedAttribute()
    {
        return $this->date_generated
            ? Carbon::parse($this->date_generated)->format('M d, Y')
            : '—';
    }

    public function getCommissionSummaryAttribute()
    {
        $agentName = $this->agent ? $this->agent->full_name : 'N/A';
        $transaction = $this->transaction ? $this->transaction->property->title ?? 'Unknown Property' : 'N/A';
        return "{$agentName} — {$transaction} ({$this->percentage}%)";
    }
}
