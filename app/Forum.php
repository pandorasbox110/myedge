<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
    
    public function user() {
        return $this->hasOne(User::class,'id','added_by');
    }
    
    public function section() {
        return $this->hasOne(Section::class,'id','audience');
    }
    
    public static function paginatedSearch($keyword,$currentuser){
        
        if($currentuser->userType->name == 'Student' || $currentuser->userType->name == 'Parent'){
            
        }else{
            $results = self::with([
                                    'user',
                                    'section'
                                ])
                            ->where('added_by',$currentuser->id) //create by yours
                            ->where('is_deleted',0) 
                            // public post
                            //class post
                            ->paginate(10);
           
        }
        
        $results->appends([
                'keyword' => $keyword,
                'search_pagination' => 10
            ]); 
        
      
      return $results;
    }
}
