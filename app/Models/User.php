<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'role_id','full_name','email','password','contact_number','gender','age','status'
    ];

    protected $hidden = ['password','remember_token'];

    public function role() {
        return $this->belongsTo(Role::class,'role_id','role_id');
    }

    public function propertiesAssigned() {
        return $this->belongsToMany(Property::class,'property_assignments','agent_id','property_id','user_id','property_id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class,'agent_id','user_id');
    }

    public function commissions() {
        return $this->hasMany(Commission::class,'agent_id','user_id');
    }

    public function isRole($roleName) {
        return optional($this->role)->role_name === $roleName;
    }
}
