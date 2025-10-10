<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model {
    public $timestamps = false;
    protected $primaryKey = 'log_id';
    protected $fillable = ['user_id','action','target_table','target_id','timestamp','remarks'];
}
