<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalConfig extends Model
{
    use HasFactory;


    // application_name,application_email,company_name,max_referral_user,company_address,registration_bonus,game_initialize_coin_amount,game_win_coin_deduct_percentage
}
