<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAssignment extends Model {
    public $timestamps = false;
    protected $primaryKey = 'assign_id';
    protected $fillable = ['agent_id','property_id','assigned_date'];

    protected $dates = ['assigned_date'];

    public function agent()
    {
        return $this->belongsTo(User::class,'agent_id','user_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class,'property_id','property_id');
    }
}
