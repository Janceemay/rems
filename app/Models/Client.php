<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {
    protected $primaryKey = 'client_id';
    protected $fillable = ['user_id','current_job','financing_type','remarks'];

    public function user() {
        return $this->belongsTo(User::class,'user_id','user_id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class,'client_id','client_id');
    }
}
