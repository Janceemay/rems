<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'client_id';
    protected $fillable = [
    'user_id',
    'relationship_status',
    'birthday',
    'age',
    'gender',
    'contact_number',
    'address',
    'source_of_income',
    'current_job',
    'financing_type',
    'remarks'
];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'client_id', 'client_id');
    }

    public function payments()
    {
        return $this->hasManyThrough(
            Payment::class,
            Transaction::class,
            'client_id',
            'transaction_id',
            'client_id',
            'transaction_id'
        );
    }

    public function getFullNameAttribute()
    {
        return $this->user ? $this->user->full_name : null;
    }

    public function getTotalTransactionsAttribute()
    {
        return $this->transactions()->count();
    }

    public function getTotalPaymentsAttribute()
    {
        return $this->payments()->sum('amount');
    }
}
