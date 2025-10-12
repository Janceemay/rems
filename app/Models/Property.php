<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'property_id';
    protected $fillable = [
        'developer_id',
        'property_code',
        'property_type',
        'title',
        'location',
        'size',
        'price',
        'status',
        'description',
        'image_url',
        'floor_plan'
    ];

    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id', 'developer_id');
    }

    public function assignments()
    {
        return $this->hasMany(PropertyAssignment::class, 'property_id', 'property_id');
    }

    public function assignedAgents()
    {
        return $this->belongsToMany(
            User::class,
            'property_assignments',
            'property_id',
            'agent_id',
            'property_id',
            'user_id'
        )->withTimestamps();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'property_id', 'property_id');
    }

    public function payments()
    {
        return $this->hasManyThrough(
            Payment::class,
            Transaction::class,
            'property_id',
            'transaction_id',
            'property_id',
            'transaction_id'
        );
    }

    public function getDisplayNameAttribute()
    {
        return "{$this->property_code} - {$this->title}";
    }

    public function getImageUrlAttribute($value)
    {
        if (!$value) {
            // return asset('images/no-image.png');
        }

        return filter_var($value, FILTER_VALIDATE_URL)
            ? $value
            : asset('storage/' . $value);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'available' => 'Available',
            'sold' => 'Sold',
            'reserved' => 'Reserved',
            'archived' => 'Archived',
            default => ucfirst($this->status),
        };
    }

    public function getTransactionCountAttribute()
    {
        return $this->transactions()->count();
    }

    public function getTotalSalesAttribute()
    {
        return $this->transactions()->sum('total_amount');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
