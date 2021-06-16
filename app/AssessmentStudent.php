<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentStudent extends Model
{
    protected $cast = ['id' => 'string'];
	protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
    
    protected $appends = [
        'total_score',
        'over_score'
    ];
    
    public function getTotalScoreAttribute() {
         return $this->submittedAssessment->sum('apoint');
    }
    
    public function getOverScoreAttribute() {
         return $this->submittedAssessment->sum('point');
    }
    
    public function user() {
        return $this->hasOne(User::class,'id','student_id');
    }
    
    public function submittedAssessment() {
        return $this->hasMany(SubmittedAssessment::class,'assessment_student_id','id');
    }
}
