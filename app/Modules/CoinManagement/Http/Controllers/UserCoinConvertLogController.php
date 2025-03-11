<?php

namespace App\Modules\CoinManagement\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Modules\AppUserBalance\Models\AppUserBalance;
use App\Modules\AppUserBalance\Models\AppUserBalanceDetail;
use App\Modules\CoinManagement\Http\Resources\UserCoinConvertLogResource;
use App\Modules\CoinManagement\Models\UserCoin;
use App\Modules\CoinManagement\Models\UserCoinConvertLog;
use App\Modules\CoinManagement\Models\UserCoinDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserCoinConvertLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function apiCoinConvertStore(Request $request)
    {

        $rules = [
            "amount" => 'required|numeric',
            "password" => 'required|string',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
            ]);
        }

        if (!isset(auth()->user()->coin) || (auth()->user()->coin->coin < $request->amount)) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have enough balance.',
            ]);
        }
        if (!Hash::check($request->password, auth()->user()->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password is not currect.',
            ]);
        }
        if ($request->amount <= 0) {
            return response()->json([
                'status' => false,
                'message' => 'Amount can not be 0.',
            ]);
        }

        $minimum_coin = Helper::get_config('minimum_convert_coin') ?? 0;
        if ($minimum_coin > $request->amount) {
            return response()->json([
                'status' => false,
                'message' => 'Minimun coin convert amount is ' . $minimum_coin . ' .',
            ]);
        }

        $convert_rate = Helper::get_config('coin_convert_amount') ?? 0;
        if ($convert_rate <= 0) {
            return response()->json([
                'status' => false,
                'message' => 'Please contact with support center. Rate is not fixed yet.',
            ]);
        }

        $balance = $request->amount / $convert_rate;

        $transactionFail = false;
        DB::beginTransaction();
        try {
            $convert_log = new UserCoinConvertLog();
            $convert_log->app_user_id = auth()->id();
            $convert_log->coin = $request->amount;
            $convert_log->coin_rate = $convert_rate;
            $convert_log->balance = $balance;
            if ($convert_log->save()) {

                // For Coin Giving
                $g_user = UserCoin::where('app_user_id', auth()->id())->first();
                $g_user->coin -= $request->amount;
                if ($g_user->update()) {
                    $b_detail = new UserCoinDetail();
                    $b_detail->source = 'COIN_CONVERT';
                    $b_detail->coin_type = 'SUB';
                    $b_detail->user_coin_id = $g_user->id;
                    $b_detail->coin = $request->amount;
                    $b_detail->user_coin_convert_log_id = $convert_log->id;
                    if (!$b_detail->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }

                // For Balance update
                $r_user = AppUserBalance::where('app_user_id', auth()->id())->first();
                $r_user->balance += $balance;

                if ($r_user->save()) {
                    $r_b_detail = new AppUserBalanceDetail();
                    $r_b_detail->app_user_balance_id = $r_user->id;
                    $r_b_detail->source = 'COIN_CONVERT';
                    $r_b_detail->balance_type = 'ADD';
                    $r_b_detail->balance = $balance;
                    $r_b_detail->user_coin_convert_log_id = $convert_log->id;
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
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong.',
                ]);
            } else {
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Coin convert done successfully.',
                    'taka' => $balance,
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function apiCoinConvertHistory()
    {
        $datas = UserCoinConvertLog::where('app_user_id', auth()->id())->orderBy('id', 'DESC')->get();

        return response(UserCoinConvertLogResource::collection($datas));
    }

    public function apiBalanceToCoinConvertStore(Request $request)
    {

        $rules = [
            "amount" => 'required|numeric',
            "password" => 'required|string',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
            ]);
        }

        if (!isset(auth()->user()->coin) || (auth()->user()->coin->coin < $request->amount)) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have enough balance.',
            ]);
        }
        if (!Hash::check($request->password, auth()->user()->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password is not currect.',
            ]);
        }
        if ($request->amount <= 0) {
            return response()->json([
                'status' => false,
                'message' => 'Amount can not be 0.',
            ]);
        }

        $minimum_coin = Helper::get_config('minimum_convert_coin') ?? 0;
        if ($minimum_coin > $request->amount) {
            return response()->json([
                'status' => false,
                'message' => 'Minimun coin convert amount is ' . $minimum_coin . ' .',
            ]);
        }

        $convert_rate = Helper::get_config('coin_convert_amount') ?? 0;
        if ($convert_rate <= 0) {
            return response()->json([
                'status' => false,
                'message' => 'Please contact with support center. Rate is not fixed yet.',
            ]);
        }

        $balance = $request->amount / $convert_rate;

        $transactionFail = false;
        DB::beginTransaction();
        try {
            $convert_log = new UserCoinConvertLog();
            $convert_log->app_user_id = auth()->id();
            $convert_log->coin = $request->amount;
            $convert_log->coin_rate = $convert_rate;
            $convert_log->balance = $balance;
            if ($convert_log->save()) {

                // For Coin Giving
                $g_user = UserCoin::where('app_user_id', auth()->id())->first();
                $g_user->coin -= $request->amount;
                if ($g_user->update()) {
                    $b_detail = new UserCoinDetail();
                    $b_detail->source = 'COIN_CONVERT';
                    $b_detail->coin_type = 'SUB';
                    $b_detail->user_coin_id = $g_user->id;
                    $b_detail->coin = $request->amount;
                    $b_detail->user_coin_convert_log_id = $convert_log->id;
                    if (!$b_detail->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }

                // For Balance update
                $r_user = AppUserBalance::where('app_user_id', auth()->id())->first();
                $r_user->balance += $balance;

                if ($r_user->save()) {
                    $r_b_detail = new AppUserBalanceDetail();
                    $r_b_detail->app_user_balance_id = $r_user->id;
                    $r_b_detail->source = 'COIN_CONVERT';
                    $r_b_detail->balance_type = 'ADD';
                    $r_b_detail->balance = $balance;
                    $r_b_detail->user_coin_convert_log_id = $convert_log->id;
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
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong.',
                ]);
            } else {
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Coin convert done successfully.',
                    'taka' => $balance,
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserCoinConvertLog $userCoinConvertLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserCoinConvertLog $userCoinConvertLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserCoinConvertLog $userCoinConvertLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserCoinConvertLog $userCoinConvertLog)
    {
        //
    }
}
