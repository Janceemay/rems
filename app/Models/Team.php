<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'team_id';
    protected $fillable = [
        'manager_id',
        'name',
        'description'
    ];

    public function manager()
    {
        return $this->belongsTo(SalesManager::class, 'manager_id', 'manager_id');
    }

    public function agents()
    {
        return $this->hasMany(Agent::class, 'team_id', 'team_id');
    }

    public function quotas()
    {
        return $this->hasMany(Quota::class, 'team_id', 'team_id');
    }

    public function commissions()
    {
        return $this->hasManyThrough(
            Commission::class,
            Agent::class,
            'team_id',
            'agent_id',
            'team_id',
            'agent_id'
        );
    }

    public function getAgentCountAttribute()
    {
        return $this->agents()->count();
    }

    public function getTotalCommissionsAttribute()
    {
        return $this->commissions()->sum('amount');
    }

    public function getTotalSalesAttribute()
    {
        return $this->agents()
                    ->withSum('transactions', 'total_amount')
                    ->get()
                    ->sum('transactions_sum_total_amount');
    }
}
