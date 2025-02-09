<?php

namespace App\Modules\AppUser\Models;

use App\Modules\AppUserBalance\Models\AppUserBalance;
use App\Modules\AppUserBalance\Models\BalanceTransferLog;
use App\Modules\AppUserBalance\Models\DepositLog;
use App\Modules\AppUserBalance\Models\LevelIncomeLog;
use App\Modules\AppUserBalance\Models\WithdrawLog;
use App\Modules\CoinManagement\Models\CoinTransferLog;
use App\Modules\CoinManagement\Models\UserCoin;
use App\Modules\CoinManagement\Models\UserCoinConvertLog;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AppUser extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'app_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function coin()
    {
        return $this->belongsTo(UserCoin::class, 'id', 'app_user_id');
    }
    public function balance()
    {
        return $this->belongsTo(AppUserBalance::class, 'id', 'app_user_id');
    }
    public function deposit()
    {
        return $this->hasMany(DepositLog::class, 'app_user_id')->where('status',2);
    }
    public function withdraw()
    {
        return $this->hasMany(WithdrawLog::class, 'app_user_id')->where('status',2);
    }
    public function coinTransferGiven()
    {
        return $this->hasMany(CoinTransferLog::class, 'given_by');
    }
    public function balanceTransferGiven()
    {
        return $this->hasMany(BalanceTransferLog::class, 'given_by');
    }
    public function coinConvertLog()
    {
        return $this->hasMany(UserCoinConvertLog::class, 'app_user_id');
    }
    public function refferalUsers()
    {
        return $this->hasMany(AppUser::class, 'referral_id','user_id');
    }
    public function totalStarIncome()
    {
        return $this->hasMany(LevelIncomeLog::class,'app_user_id')->where('type','GAIN');
    }
}
