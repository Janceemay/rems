<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model {
    protected $primaryKey = 'commission_id';
    protected $fillable = ['transaction_id','agent_id','percentage','amount','approval_status','approved_by','date_generated'];

    protected $dates = ['date_generated'];

    public function agent() {
        return $this->belongsTo(User::class,'agent_id','user_id');
    }

    public function transaction() {
        return $this->belongsTo(Transaction::class,'transaction_id','transaction_id');
    }

    public function approver() {
        return $this->belongsTo(User::class,'approved_by','user_id');
    }
}
