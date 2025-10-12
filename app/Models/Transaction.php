<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'transaction_id';
    protected $fillable = [
        'client_id',
        'agent_id',
        'property_id',
        'status',
        'approval_stage',
        'request_date',
        'approval_date',
        'cancellation_reason',
        'notes',
        'total_amount'
    ];

    protected $dates = ['request_date', 'approval_date'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id', 'user_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'property_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'transaction_id', 'transaction_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'transaction_id', 'transaction_id');
    }

    public function getTotalPaymentsAttribute()
    {
        return $this->payments()->sum('amount');
    }

    public function getBalanceAttribute()
    {
        if (is_null($this->total_amount)) {
            return 0;
        }
        return $this->total_amount - $this->total_payments;
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCanceled(): bool
    {
        return $this->status === 'canceled';
    }

    public function getApprovalStageLabelAttribute()
    {
        return match ($this->approval_stage) {
            'agent_review' => 'Agent Review',
            'manager_review' => 'Manager Review',
            'finance_verification' => 'Finance Verification',
            'final_approval' => 'Final Approval',
            default => ucfirst($this->approval_stage ?? 'Pending'),
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'approved' => 'Approved',
            'canceled' => 'Canceled',
            'completed' => 'Completed',
            default => ucfirst($this->status ?? 'Pending'),
        };
    }

    public function getTransactionSummaryAttribute()
    {
        return "{$this->property->title} — {$this->client->user->full_name}";
    }
}
