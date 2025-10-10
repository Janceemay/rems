<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quota extends Model {
    protected $primaryKey = 'quota_id';
    protected $fillable = ['manager_id','agent_id','target_sales','achieved_sales','period_start','period_end','status'];
}
