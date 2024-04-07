<?php

namespace App\Modules\CoinManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCoinDetail extends Model
{
    use HasFactory;

    public function usercoin()
    {
        return $this->belongsTo(UserCoin::class, 'user_coin_id');
    }
}
