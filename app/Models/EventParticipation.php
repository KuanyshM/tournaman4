<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'event_id',
        'status_id'
    ];


    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
    public function event()
    {
        return $this->belongsTo("App\Models\Event");
    }
    public function status()
    {
        return $this->belongsTo("App\Models\ParticipationStatus");
    }
}
