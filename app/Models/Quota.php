<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Quota extends Model
{
    use HasFactory;

    protected $primaryKey = 'quota_id';
    protected $fillable = [
        'manager_id',
        'agent_id',
        'team_id',
        'target_sales',
        'achieved_sales',
        'period_start',
        'period_end',
        'status',
        'remarks'
    ];

    protected $casts = [
        'period_start' => 'datetime',
        'period_end' => 'datetime',
    ];

    public function manager()
    {
        return $this->belongsTo(SalesManager::class, 'manager_id', 'manager_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'agent_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'team_id');
    }

    public function getProgressAttribute()
    {
        if (!$this->target_sales || $this->target_sales == 0) return 0;
        return round(($this->achieved_sales / $this->target_sales) * 100, 2);
    }

    public function getIsOverdueAttribute(): bool
    {
        if ($this->is_achieved) {
            return false;
        }

        if (!$this->period_end) {
            return false;
        }

        $periodEnd = $this->period_end instanceof Carbon ? $this->period_end : Carbon::parse($this->period_end);

        return $periodEnd->isPast();
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'active' => 'Active',
            'achieved' => 'Achieved',
            'overdue' => 'Overdue',
            'inactive' => 'Inactive',
            default => ucfirst($this->status ?? 'Active'),
        };
    }

    public function getPeriodLabelAttribute()
    {
        if (!$this->period_start || !$this->period_end) return 'N/A';
        $start = Carbon::parse($this->period_start)->format('M d, Y');
        $end = Carbon::parse($this->period_end)->format('M d, Y');
        return "{$start} - {$end}";
    }

    public function updateStatus()
    {
        if ($this->is_achieved) {
            $this->status = 'achieved';
        } elseif ($this->is_overdue) {
            $this->status = 'overdue';
        } else {
            $this->status = 'active';
        }
        $this->save();
    }
}
