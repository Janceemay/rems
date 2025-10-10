<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model {
    protected $primaryKey = 'report_id';
    protected $fillable = ['generated_by','report_type','report_format','file_path','date_generated'];
}
