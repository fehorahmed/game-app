<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppUserGameSession extends Model
{
    use HasFactory;

    public function appUserGameSession()
    {
        return $this->hasMany(AppUserGameSessionDetail::class, 'app_user_game_session_id', 'id');
    }
}
