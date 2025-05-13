<?php

namespace App\Modules\AppUserBalance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppUserBalanceDetail extends Model
{
    use HasFactory;

    public function appUserBalance(){
        return $this->belongsTo(AppUserBalance::class,'app_user_balance_id');
    }
}
