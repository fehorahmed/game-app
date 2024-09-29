<?php

namespace App\Http\Controllers;

use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUserBalance\Models\DepositLog;
use App\Modules\AppUserBalance\Models\WithdrawLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        $today_member_joined =  AppUser::whereDate('created_at',today())->count();
        $today_add_money =  DepositLog::whereDate('deposit_date',today())->where('status',2)->sum('amount');
        $today_withdraw =  WithdrawLog::whereDate('withdraw_date',today())->where('status',2)->sum('amount');

        $monthly_member_joined = AppUser::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])->count();
        $monthly_add_money = DepositLog::whereBetween('deposit_date', [Carbon::now()->startOfMonth(), Carbon::now()])->where('status',2)->sum('amount');
        $monthly_withdraw = WithdrawLog::whereBetween('withdraw_date', [Carbon::now()->startOfMonth(), Carbon::now()])->where('status',2)->sum('amount');

       $data=[
        'today_member_joined' => $today_member_joined,
        'today_add_money' => $today_add_money,
        'today_withdraw' => $today_withdraw,
        'monthly_member_joined' => $monthly_member_joined,
        'monthly_add_money' => $monthly_add_money,
        'monthly_withdraw' => $monthly_withdraw,
       ];


        return view('dashboard')->with($data);
    }
}
