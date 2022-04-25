<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'verified',
        'facebook',
        'twitter'
    ];
    public function followers()
    {
        return $this->hasMany('App\Models\OrganizationFollowing');
    }
    public function getFollowersCount()
    {
        return $this->followers()->count() ;
    }
}
