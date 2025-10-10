<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model {
    protected $primaryKey = 'developer_id';
    protected $fillable = ['developer_name','contact_person','contact_number','email','address'];

    public function properties() {
        return $this->hasMany(Property::class,'developer_id','developer_id');
    }
}
