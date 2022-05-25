<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTeam extends Model
{
    use HasFactory;
/*    protected $fillable = [
        'to_user_id',
        'from_user_id',
        'status_id',
        'team_id'
    ];*/
    public function team()
    {
        return $this->belongsTo("App\Models\Team");
    }
    public function status()
    {
        return $this->belongsTo("App\Models\TeamStatus");
    }
    public function from_user()
    {
        return $this->belongsTo("App\Models\User");
    }
    public function to_user()
    {
        return $this->belongsTo("App\Models\User");
    }

}
