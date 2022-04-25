<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\EventComment');
    }
    public function likes()
    {
        return $this->hasMany('App\Models\EventLike');
    }
    public function participations()
    {
        return $this->hasMany('App\Models\EventParticipation');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public  function  canParticipate()
    {
        $date = date('Y-m-d h:i:s a', time());
        if($date>=$this->reg_start_date  && $date<=$this->reg_end_date){
            return true;
        }else{
            return false;
        }
    }
}
