<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    protected $primaryKey = 'payment_id';
    protected $fillable = ['transaction_id','due_date','amount_due','amount_paid','payment_date','payment_status','remarks'];

    protected $dates = ['due_date','payment_date'];

    public function transaction() {
        return $this->belongsTo(Transaction::class,'transaction_id','transaction_id');
    }
}
