<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Model
{
    use HasFactory;

    protected $table = 'agents';
    protected $primaryKey = 'agent_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'user_id',
        'rank',
        'contact_no',
        'email',
        'team_id',
        'manager_id',
        'remarks',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function assignedProperties()
    {
        return $this->belongsToMany(
            Property::class,
            'property_assignments',
            'agent_id',
            'property_id',
            'agent_id',
            'property_id'
        )->withTimestamps();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'agent_id', 'agent_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'agent_id', 'agent_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'team_id');
    }

    public function getFullNameAttribute()
    {
        return $this->user ? $this->user->full_name : null;
    }

    public function getAssignedPropertyCountAttribute()
    {
        return $this->assignedProperties()->count();
    }

    public function getTotalCommissionsAttribute()
    {
        return $this->commissions()->sum('amount');
    }
}
