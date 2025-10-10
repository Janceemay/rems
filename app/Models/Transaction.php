<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    protected $primaryKey = 'transaction_id';
    protected $fillable = ['client_id','agent_id','property_id','status','request_date','approval_date','cancellation_reason','notes'];

    protected $dates = ['request_date','approval_date'];

    public function client() {
        return $this->belongsTo(Client::class,'client_id','client_id');
    }

    public function agent() {
        return $this->belongsTo(User::class,'agent_id','user_id');
    }

    public function property() {
        return $this->belongsTo(Property::class,'property_id','property_id');
    }

    public function payments() {
        return $this->hasMany(Payment::class,'transaction_id','transaction_id');
    }

    public function commissions() {
        return $this->hasMany(Commission::class,'transaction_id','transaction_id');
    }
}
