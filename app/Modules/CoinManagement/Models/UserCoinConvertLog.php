<?php

namespace App\Modules\CoinManagement\Models;

use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCoinConvertLog extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(AppUser::class,'app_user_id');
    }
}
