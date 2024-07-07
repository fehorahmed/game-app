<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppUserReferralRequest extends Model
{
    use HasFactory;


    public function appUser()
    {
        return $this->belongsTo(AppUser::class, 'app_user_id');
    }
}
