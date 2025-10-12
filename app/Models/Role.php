<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'role_id';
    protected $fillable = [
        'role_name',
        'description'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }

    public function isRole(string $name): bool
    {
        return strtolower($this->role_name) === strtolower($name);
    }

    public function getRoleLabelAttribute()
    {
        return ucfirst($this->role_name);
    }

    public static function defaultRoles(): array
    {
        return [
            'client' => 'Registered property buyers or clients',
            'agent' => 'Real estate agents handling sales',
            'manager' => 'Sales managers overseeing agents and teams',
            'admin' => 'System administrators with full access'
        ];
    }
}
