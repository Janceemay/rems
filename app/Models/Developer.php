<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Developer extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'developer_id';
    protected $fillable = [
        'developer_name',
        'contact_person',
        'contact_number',
        'email',
        'address',
        'description',
        'status'
    ];

    public function properties()
    {
        return $this->hasMany(Property::class, 'developer_id', 'developer_id');
    }

    public function managers()
    {
        return $this->belongsToMany(
            SalesManager::class,
            'developer_assignments',
            'developer_id',
            'manager_id',
            'developer_id',
            'manager_id'
        )->withTimestamps();
    }

    public function getPropertyCountAttribute()
    {
        return $this->properties()->count();
    }

    public function getTotalSalesAttribute()
    {
        return $this->properties()
                    ->withSum('transactions', 'total_amount')
                    ->get()
                    ->sum('transactions_sum_total_amount');
    }

    public function getDisplayNameAttribute()
    {
        return "{$this->developer_name} ({$this->contact_person})";
    }
}
