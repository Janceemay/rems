<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class AuditLog extends Model
{
    use HasFactory;

    protected $primaryKey = 'log_id';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'action',
        'target_table',
        'target_id',
        'remarks'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function getFormattedTimestampAttribute()
    {
        return $this->created_at
            ? Carbon::parse($this->created_at)->format('M d, Y h:i A')
            : '—';
    }

    public function getSummaryAttribute()
    {
        $username = $this->user ? $this->user->full_name : 'Unknown User';
        return "{$username} performed '{$this->action}' on {$this->target_table} (ID: {$this->target_id})";
    }

    public function getIsCriticalAttribute(): bool
    {
        $criticalActions = ['delete', 'approve', 'reject', 'update_status'];
        return in_array(strtolower($this->action), $criticalActions);
    }

    protected static function booted()
    {
        static::creating(function ($log) {
            if (!$log->created_at) {
                $log->created_at = now();
            }
        });
    }
}
