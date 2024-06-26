<?php

namespace App\Modules\Game\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    use HasFactory;

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
