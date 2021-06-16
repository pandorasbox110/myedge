<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionTeacher extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
    
    
    public function user() {
        return $this->hasOne(User::class,'id','teacher_id');
    }
}
