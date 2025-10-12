<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notif_id';
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
        'created_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function getIsUnreadAttribute(): bool
    {
        return !$this->is_read;
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    public function getFormattedCreatedAtAttribute()
    {
        if (!$this->created_at) return '—';
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            'transaction' => 'Transaction Update',
            'property' => 'Property Notice',
            'commission' => 'Commission Alert',
            'payment' => 'Payment Notice',
            'system' => 'System Message',
            default => 'General',
        };
    }

    protected static function booted()
    {
        static::creating(function ($notif) {
            if (!$notif->created_at) {
                $notif->created_at = now();
            }
        });
    }
}
