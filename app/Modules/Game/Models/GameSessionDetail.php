<?php

namespace App\Modules\Game\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSessionDetail extends Model
{
    use HasFactory;

    public function gameSession(){
        return $this->belongsTo(GameSession::class,'game_session_id');
    }
}
