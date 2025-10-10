<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    protected $primaryKey = 'notif_id';
    public $timestamps = false;
    protected $fillable = ['user_id','title','message','is_read','created_at'];
}
