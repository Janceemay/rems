<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';
    protected $fillable = [
        'transaction_id',
        'due_date',
        'amount_due',
        'amount_paid',
        'payment_date',
        'payment_status',
        'remarks'
    ];

    protected $dates = ['due_date', 'payment_date'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    public function client()
    {
        return $this->hasOneThrough(
            Client::class,
            Transaction::class,
            'transaction_id', 
            'client_id',
            'transaction_id',
            'client_id'
        );
    }

    public function getBalanceAttribute()
    {
        $due = $this->amount_due ?? 0;
        $paid = $this->amount_paid ?? 0;
        return max($due - $paid, 0);
    }

    public function getIsFullyPaidAttribute(): bool
    {
        return $this->amount_paid >= $this->amount_due;
    }

    public function getIsOverdueAttribute(): bool
    {
        if (!$this->due_date) {
            return false;
        }

        $dueDate = $this->due_date instanceof Carbon ? $this->due_date : Carbon::parse($this->due_date);

        return !$this->is_fully_paid && $dueDate->isPast();
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->payment_status) {
            'pending' => 'Pending',
            'partial' => 'Partially Paid',
            'paid' => 'Fully Paid',
            'overdue' => 'Overdue',
            'approved' => 'Approved',
            default => ucfirst($this->payment_status ?? 'Pending'),
        };
    }

    public function getPaymentProgressAttribute()
    {
        if (!$this->amount_due || $this->amount_due == 0) return 0;
        return round(($this->amount_paid / $this->amount_due) * 100, 2);
    }

    public function getFormattedPaymentDateAttribute()
    {
        return $this->payment_date ? Carbon::parse($this->payment_date)->format('M d, Y') : '—';
    }

    public function getFormattedDueDateAttribute()
    {
        return $this->due_date ? Carbon::parse($this->due_date)->format('M d, Y') : '—';
    }
}
