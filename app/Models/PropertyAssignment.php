<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class PropertyAssignment extends Model
{
    use HasFactory;

    protected $primaryKey = 'assign_id';
    protected $fillable = [
        'agent_id',
        'property_id',
        'assigned_by',
        'assigned_date',
        'remarks'
    ];

    protected $dates = ['assigned_date'];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id', 'user_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'property_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by', 'user_id');
    }

    public function getFormattedAssignedDateAttribute()
    {
        return $this->assigned_date
            ? Carbon::parse($this->assigned_date)->format('M d, Y')
            : '—';
    }

    public function getAssignmentSummaryAttribute()
    {
        $agent = $this->agent ? $this->agent->full_name : 'N/A';
        $property = $this->property ? $this->property->title ?? 'Unnamed Property' : 'N/A';
        return "{$agent} assigned to {$property}";
    }

    public function getIsManagerAssignedAttribute(): bool
    {
        return $this->assignedBy && $this->assignedBy->role && $this->assignedBy->role->role_name === 'manager';
    }

    protected static function booted()
    {
        static::creating(function ($assignment) {
            if (!$assignment->assigned_date) {
                $assignment->assigned_date = now();
            }
        });
    }
}
