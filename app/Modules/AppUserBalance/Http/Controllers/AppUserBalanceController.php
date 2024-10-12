<?php

namespace App\Modules\AppUserBalance\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUserBalance\Models\AppUserBalance;
use App\Modules\AppUserBalance\Models\AppUserBalanceDetail;
use App\Modules\AppUserBalance\Models\BalanceTransferLog;
use App\Modules\CoinManagement\Models\CoinTransferLog;
use App\Modules\CoinManagement\Models\UserCoin;
use App\Modules\CoinManagement\Models\UserCoinDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AppUserBalanceController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("AppUserBalance::welcome");
    }
    public function appUserBalanceTransfer()
    {
        return view("frontend.transfer.balance_transfer");
    }

    public function appUserBalanceTransferStore(Request $request)
    {

        $request->validate([
            "user_id" => 'required|numeric',
            "amount" => 'required|numeric',
            "password" => 'required|string|max:20',
        ]);
        $user = AppUser::where('user_id', $request->user_id)->where('status', 1)->first();
        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Given user id not matched.');
        }

        if ($user->id == auth()->id()) {
            return redirect()->back()->withInput()->with('error', 'Given User ID is your.');
        }

        if(!Hash::check($request->password,auth()->user()->password)){
            return redirect()->back()->withInput()->with('error', 'Password is not currect.');
        }
        // dd($request->all());
        if (!isset(auth()->user()->balance) || (auth()->user()->balance->balance < $request->amount)) {
            return redirect()->back()->withInput()->with('error', 'You do not have enough balance.');
        }

        if (!isset(auth()->user()->balance->star) || (auth()->user()->balance->star < 1)) {
            return redirect()->back()->withInput()->with('error', 'You do not have enough star for transfer. Please buy star first.');
        }

        $withdraw_limit = Helper::get_star_withdraw_limit(auth()->user()->balance->star);

        $total_withdraw = auth()->user()->withdraw->sum('amount');
        if ($withdraw_limit < ($total_withdraw + $request->amount)) {
            return redirect()->back()->withInput()->with('error', "Your withdraw limit is {$withdraw_limit}. Please buy star for increment withdraw limit.");
        }



        $transactionFail = false;
        DB::beginTransaction();
        try {
            $transfer_log = new BalanceTransferLog();
            $transfer_log->given_by = auth()->id();
            $transfer_log->received_by = $user->id;
            $transfer_log->balance = $request->amount;
            if ($transfer_log->save()) {

                // For Given User
                $g_user = AppUserBalance::where('app_user_id', auth()->id())->first();
                $g_user->balance -= $request->amount;
                if ($g_user->update()) {
                    $b_detail = new AppUserBalanceDetail();
                    $b_detail->app_user_balance_id = $g_user->id;
                    $b_detail->source = 'BALANCE_TRANSFER';
                    $b_detail->balance_type = 'SUB';
                    $b_detail->balance = $request->amount;
                    $b_detail->balance_transfer_log_id = $transfer_log->id;
                    if (!$b_detail->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }

                // For received User
                $r_user = AppUserBalance::where('app_user_id', $user->id)->first();

                if (!$r_user) {
                    $r_user = new AppUserBalance();
                    $r_user->app_user_id = $user->id;
                    $r_user->balance = $request->amount;
                } else {
                    $r_user->balance += $request->amount;
                }

                if ($r_user->save()) {
                    $r_b_detail = new AppUserBalanceDetail();
                    $r_b_detail->app_user_balance_id = $r_user->id;
                    $r_b_detail->source = 'BALANCE_TRANSFER';
                    $r_b_detail->balance_type = 'ADD';
                    $r_b_detail->balance = $request->amount;
                    $r_b_detail->balance_transfer_log_id = $transfer_log->id;
                    if (!$r_b_detail->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }
            } else {
                $transactionFail = true;
            }

            if ($transactionFail) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', 'Something went wrong.');
            } else {
                DB::commit();
                return redirect()->route('user.balance_transfer.history')->with('success', 'Transfer successfully done.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }



    public function appUserBalanceTransferHistory()
    {
        $transfers = BalanceTransferLog::where('given_by', auth()->id())->orderBy('id', 'DESC')->get();

        return view("frontend.transfer.balance_transfer_history", compact('transfers'));
    }

    public function appUserCoinTransfer()
    {
        return view("frontend.transfer.coin_transfer");
    }

    public function appUserCoinTransferStore(Request $request)
    {

        $request->validate([
            "user_id" => 'required|numeric',
            "amount" => 'required|numeric',
            "password" => 'required|string|max:20',
        ]);
        $user = AppUser::where('user_id', $request->user_id)->where('status', 1)->first();
        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Given user id not matched.');
        }

        if ($user->id == auth()->id()) {
            return redirect()->back()->withInput()->with('error', 'Given User ID is your.');
        }
        if(!Hash::check($request->password,auth()->user()->password)){
            return redirect()->back()->withInput()->with('error', 'Password is not currect.');
        }
        // dd($request->all());
        if (!isset(auth()->user()->coin) || (auth()->user()->coin->coin < $request->amount)) {
            return redirect()->back()->withInput()->with('error', 'You do not have enough balance.');
        }

        if (!isset(auth()->user()->balance->star) || (auth()->user()->balance->star < 1)) {
            return redirect()->back()->withInput()->with('error', 'You do not have enough star for transfer. Please buy star first.');
        }

        $transfer_limit = Helper::get_star_coin_transfer_limit(auth()->user()->balance->star);

        $total_coin_transfer = auth()->user()->coinTransferGiven->sum('coin');



        if ($transfer_limit < ($total_coin_transfer + $request->amount)) {
            return redirect()->back()->withInput()->with('error', "Your transfer limit is {$transfer_limit}. Please buy star for increment withdraw limit.");
        }

        // dd($total_coin_transfer);

        $transactionFail = false;
        DB::beginTransaction();
        try {
            $transfer_log = new CoinTransferLog();
            $transfer_log->given_by = auth()->id();
            $transfer_log->received_by = $user->id;
            $transfer_log->coin = $request->amount;
            if ($transfer_log->save()) {

                // For Given User
                $g_user = UserCoin::where('app_user_id', auth()->id())->first();
                $g_user->coin -= $request->amount;
                if ($g_user->update()) {
                    $b_detail = new UserCoinDetail();
                    $b_detail->source = 'COIN_TRANSFER';
                    $b_detail->coin_type = 'SUB';
                    $b_detail->user_coin_id = $g_user->id;
                    $b_detail->coin = $request->amount;
                    $b_detail->coin_transfer_log_id = $transfer_log->id;
                    if (!$b_detail->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }

                // For received User
                $r_user = UserCoin::where('app_user_id', $user->id)->first();

                if (!$r_user) {
                    $r_user = new UserCoin();
                    $r_user->app_user_id = $user->id;
                    $r_user->coin = $request->amount;
                } else {
                    $r_user->coin += $request->amount;
                }

                if ($r_user->save()) {
                    $r_b_detail = new UserCoinDetail();
                    $r_b_detail->source = 'COIN_TRANSFER';
                    $r_b_detail->coin_type = 'ADD';
                    $r_b_detail->user_coin_id = $r_user->id;
                    $r_b_detail->coin = $request->amount;
                    $r_b_detail->coin_transfer_log_id = $transfer_log->id;
                    if (!$r_b_detail->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }
            } else {
                $transactionFail = true;
            }

            if ($transactionFail) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', 'Something went wrong.');
            } else {
                DB::commit();
                return redirect()->route('user.coin_transfer.history')->with('success', 'Transfer successfully done.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }
    public function appUserCoinTransferHistory()
    {
        $transfers = CoinTransferLog::where('given_by', auth()->id())->orderBy('id', 'DESC')->get();

        return view("frontend.transfer.coin_transfer_history", compact('transfers'));
    }
}
