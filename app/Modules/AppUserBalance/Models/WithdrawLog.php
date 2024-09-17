<?php

namespace App\Modules\AppUserBalance\Models;

use App\Models\PaymentMethod;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawLog extends Model
{
    use HasFactory;
    public function method(){
        return $this->belongsTo(PaymentMethod::class,'payment_method_id');
    }
    public function appUser(){
        return $this->belongsTo(AppUser::class,'app_user_id');
    }
}
