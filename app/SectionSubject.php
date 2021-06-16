<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionSubject extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
    public $incrementing = false;
    
    protected $appends = [
      'serimg'
    ];
    
    public function getSerimgAttribute() {
      
      $serverurl=env('APP_URL');
      
      return $serverurl . $this->image;
    }

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->init();
        });
    }

    private function init() {
        $this->id = self::createID();
        $this->is_deleted = 0;
    }
    /* Static Methods */
    public static function createID() 
    {
        $today = date('Ymdhis');
        $count = self::whereDate('date_created',$today)->count() + 1;
        return "SS-".date('Ymdhis')."-$count";
    } 

    //relationship
    public function section() {
        return $this->hasMany(Section::class,'id','section_id');
    }

    public function sectionSubjectScale() {
        return $this->hasMany(SectionSubjectScale::class,'section_subject_id','id');
    }

    public function mySubject() {
        return $this->hasOne(MySubject::class,'id','my_subject_id');
    }
    
    public function subjectAssessment() {
        return $this->hasMany(SubjectAssessment::class,'section_subject_id','id');
    }
    
    
    public static function paginatedSearch($keyword,$id,$targetStat){

        $results = self::with([
                                'mySubject.createdSubject'
                            ])
                        ->whereHas('mySubject.createdSubject',function($q) use($keyword){
                               $q->where('name','LIKE', '%'.$keyword.'%');
                         })
                        ->where('section_id',$id)
                        ->whereIn('status',$targetStat)
                        ->where('is_deleted',0)
                        ->paginate(10);
                        
        $results->appends([
            'keyword' => $keyword,
            'search_pagination' => 10
        ]);

        return $results;
    }
}
