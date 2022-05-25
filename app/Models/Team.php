<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'author_user_id'
    ];
    public function userTeam()
    {
        return $this->hasMany('App\Models\UserTeam');

    }
    public function members()
    {
        $userRequest = $this->userTeam;
        $membersCollection = collect();
        foreach ($userRequest as $ur){
            if($ur->status_id==2){
                $membersCollection->add(User::find($ur->from_user_id));
            }
        }
        return $membersCollection;

    }
    public function requests()
    {
        $userRequest = $this->userTeam;
        $membersCollection = collect();
        foreach ($userRequest as $ur){
            if($ur->status_id==1){
                $membersCollection->add(User::find($ur->from_user_id));
            }
        }
        return $membersCollection;

    }


}
