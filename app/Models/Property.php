<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model {
    protected $primaryKey = 'property_id';
    protected $fillable = [
        'developer_id','property_code','property_type','title','location','size','price','status','description','image_url','floor_plan'
    ];

    public function developer() {
        return $this->belongsTo(Developer::class,'developer_id','developer_id');
    }

    public function assignments() {
        return $this->hasMany(PropertyAssignment::class,'property_id','property_id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class,'property_id','property_id');
    }

    public function assignedAgents() {
        return $this->belongsToMany(User::class,'property_assignments','property_id','agent_id','property_id','user_id');
    }
}
