<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;
    protected $fillable = [
        'age',
        'gender',
        'genderProbability',
        'angry',
        'disgusted',
        'fearful',
        'happy',
        'neutral',
        'sad',
        'surprised',
        'state',
        'currentTime',
        'ip',
        'user_id',
    ];
}
