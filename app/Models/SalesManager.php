<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesManager extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'manager_id';
    protected $fillable = [
        'user_id',
        'department',
        'quota_id',
        'remarks'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function agents()
    {
        return $this->hasMany(Agent::class, 'manager_id', 'manager_id');
    }

    public function teams()
    {
        return $this->hasMany(Team::class, 'manager_id', 'manager_id');
    }

    public function quotas()
    {
        return $this->hasMany(Quota::class, 'manager_id', 'manager_id');
    }

    public function transactions()
    {
        return $this->hasManyThrough(
            Transaction::class,
            Agent::class,
            'manager_id',
            'agent_id',
            'manager_id',
            'agent_id'
        );
    }

    public function getFullNameAttribute()
    {
        return $this->user ? $this->user->full_name : null;
    }

    public function getAgentCountAttribute()
    {
        return $this->agents()->count();
    }

    public function getTotalSalesAttribute()
    {
        return $this->transactions()->sum('total_amount');
    }
}
