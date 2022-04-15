<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationFollowing extends Model
{
    use HasFactory;



    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
    public function organization()
    {
        return $this->belongsTo("App\Models\Orgnization");
    }
}
