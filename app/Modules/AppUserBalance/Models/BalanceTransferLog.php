<?php

namespace App\Modules\AppUserBalance\Models;

use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceTransferLog extends Model
{
    use HasFactory;

    public function givenUser(){
        return $this->belongsTo(AppUser::class,'given_by');
    }
     public function receivedUser(){
        return $this->belongsTo(AppUser::class,'received_by');
    }
}
