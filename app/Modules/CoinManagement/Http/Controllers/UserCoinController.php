<?php

namespace App\Modules\CoinManagement\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUserBalance\Models\AppUserBalance;
use App\Modules\AppUserBalance\Models\AppUserBalanceDetail;
use App\Modules\CoinManagement\DataTables\UserCoinList;
use App\Modules\CoinManagement\Models\UserCoin;
use App\Modules\CoinManagement\Models\UserCoinConvertLog;
use App\Modules\CoinManagement\Models\UserCoinDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserCoinController extends Controller
{

    public function userCoinList(UserCoinList $dataTable)
    {
        return $dataTable->render('CoinManagement::user-coin-list');
    }
    public function userCoinDetails($user_coin)
    {
        $datas = UserCoinDetail::where('user_coin_id', $user_coin)->paginate(15);
        return view('CoinManagement::user-coin-details', compact('datas'));
    }
    public function userCoinGift()
    {

        return view('CoinManagement::user-coin-gift');
    }
    public function userCoinGiftStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'user_name' => 'required|string|max:255',
            'coin' => 'required|numeric',
        ]);


        $ck_user =  AppUser::where('user_id', $request->user_id)->first();
        if (!$ck_user) {
            return redirect()->back()->withInput()->with('error', 'User not valid.');
        }

        $transactionFail = false;
        DB::beginTransaction();
        try {
            $coin = UserCoin::where('app_user_id', $ck_user->id)->first();
            if ($coin) {
                $coin->increment('coin', $request->coin);
                if ($coin->save()) {
                    $coin_detail = new UserCoinDetail();
                    $coin_detail->source  = 'BONUS';
                    $coin_detail->coin_type  = 'ADD';
                    $coin_detail->user_coin_id  = $coin->id;
                    $coin_detail->coin  = $request->coin;
                    $coin_detail->creator  = auth()->id();
                    if (!$coin_detail->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }
            } else {
                $coin = new UserCoin();
                $coin->app_user_id  = $ck_user->id;
                $coin->coin  = $request->coin;
                if ($coin->save()) {
                    $coin_detail = new UserCoinDetail();
                    $coin_detail->source  = 'BONUS';
                    $coin_detail->coin_type  = 'ADD';
                    $coin_detail->user_coin_id  = $coin->id;
                    $coin_detail->coin  = $request->coin;
                    $coin_detail->creator  = auth()->id();
                    if (!$coin_detail->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }
            }

            if ($transactionFail) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', 'Something went wrong.');
            } else {
                DB::commit();
                return redirect()->back()->withInput()->with('success', 'Coin Successfully added.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
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
    public function show(UserCoin $userCoin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserCoin $userCoin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserCoin $userCoin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserCoin $userCoin)
    {
        //
    }
    public function apiGiveCoinToUse(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric',
            'coin' => 'required|numeric',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
            ]);
        }

        $ck_user =  AppUser::find($request->user_id);
        if (!$ck_user) {
            return response()->json([
                'status' => false,
                'message' => 'User not valid.',
            ]);
        }

        $transactionFail = false;
        DB::beginTransaction();
        try {
            $coin = UserCoin::where('app_user_id', $ck_user->id)->first();
            if ($coin) {

                $coin->increment('coin', $request->coin);
                if ($coin->save()) {
                    $coin_detail = new UserCoinDetail();
                    $coin_detail->source  = 'BONUS';
                    $coin_detail->coin_type  = 'ADD';
                    $coin_detail->user_coin_id  = $coin->id;
                    $coin_detail->coin  = $request->coin;
                    // $coin_detail->creator  = $request->coin;
                    if (!$coin_detail->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }
            } else {
                $coin = new UserCoin();
                $coin->app_user_id  = $ck_user->id;
                $coin->coin  = $request->coin;
                if ($coin->save()) {
                    $coin_detail = new UserCoinDetail();
                    $coin_detail->source  = 'BONUS';
                    $coin_detail->coin_type  = 'ADD';
                    $coin_detail->user_coin_id  = $coin->id;
                    $coin_detail->coin  = $request->coin;
                    // $coin_detail->creator  = $request->coin;
                    if (!$coin_detail->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }
            }

            if ($transactionFail) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong',
                ]);
            } else {
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Coin Successfully added.',
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


    public function appUserCoinConvert()
    {

        return view("frontend.transfer.coin_convert");
    }

    public function appUserCoinConvertStore(Request $request)
    {

        $request->validate([
            "amount" => 'required|numeric',
            "password" => 'required|string',
        ]);

        if (!isset(auth()->user()->coin) || (auth()->user()->coin->coin < $request->amount)) {
            return redirect()->back()->withInput()->with('error', 'You do not have enough balance.');
        }
        if (!Hash::check($request->password, auth()->user()->password)) {
            return redirect()->back()->withInput()->with('error', 'Password is not currect.');
        }
        if ($request->amount <= 0) {
            return redirect()->back()->withInput()->with('error', 'Amount can not be 0.');
        }

        $minimum_coin = Helper::get_config('minimum_convert_coin') ?? 0;
        if ($minimum_coin > $request->amount) {
            return redirect()->back()->withInput()->with('error', 'Minimun coin convert amount is ' . $minimum_coin . ' .');
        }

        $convert_rate = Helper::get_config('coin_convert_amount') ?? 0;
        if ($convert_rate <= 0) {
            return redirect()->back()->withInput()->with('error', 'Please contact with support center. Rate is not fixed yet.');
        }

        $balance = $request->amount / $convert_rate;

        $transactionFail = false;
        DB::beginTransaction();
        try {
            $convert_log = new UserCoinConvertLog();
            $convert_log->convert_type = 'COIN';
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
                return redirect()->back()->withInput()->with('error', 'Something went wrong.');
            } else {
                DB::commit();
                return redirect()->route('user.coin_convert.history')->with('success', 'Coin convert done successfully.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function appUserCoinConvertHistory()
    {
        $datas = UserCoinConvertLog::where('app_user_id', auth()->id())
            ->where('convert_type', 'COIN')
            ->orderBy('id', 'DESC')->get();
        return view("frontend.transfer.coin_convert_history", compact('datas'));
    }
    public function appUserTakaToCoinConvert()
    {

        return view("frontend.transfer.taka_to_coin_convert");
    }
    public function appUserTakaToCoinConvertStore(Request $request)
    {



        $request->validate([
            "amount" => 'required|numeric',
            "password" => 'required|string',
        ]);
        // dd($request->all());
        $av_ck = Helper::getTakaToCoinConvertAvailableBalance(auth()->id());
        if($request->amount > $av_ck){
            return redirect()->back()->withInput()->with('error', 'You do not have enough available level income balance.');

        }
        if (!isset(auth()->user()->balance) || (auth()->user()->balance->balance < $request->amount)) {
            return redirect()->back()->withInput()->with('error', 'You do not have enough balance.');
        }
        if (!Hash::check($request->password, auth()->user()->password)) {
            return redirect()->back()->withInput()->with('error', 'Password is not currect.');
        }
        if ($request->amount <= 0) {
            return redirect()->back()->withInput()->with('error', 'Amount can not be 0.');
        }

        $minimum_coin = Helper::get_config('minimum_convert_taka_to_coin') ?? 0;
        if ($minimum_coin > $request->amount) {
            return redirect()->back()->withInput()->with('error', 'Minimun balance convert amount is ' . $minimum_coin . ' .');
        }

        $convert_rate = Helper::get_config('coin_convert_amount') ?? 0;
        if ($convert_rate <= 0) {
            return redirect()->back()->withInput()->with('error', 'Please contact with support center. Rate is not fixed yet.');
        }

        $coin = $request->amount * $convert_rate;

        $transactionFail = false;
        DB::beginTransaction();
        try {
            $convert_log = new UserCoinConvertLog();
            $convert_log->app_user_id = auth()->id();
            $convert_log->convert_type = 'BALANCE';
            $convert_log->coin = $coin;
            $convert_log->coin_rate = $convert_rate;
            $convert_log->balance = $request->amount;
            if ($convert_log->save()) {

                // For Coin Update
                $g_user = UserCoin::where('app_user_id', auth()->id())->first();
                $g_user->coin += $coin;
                if ($g_user->update()) {
                    $b_detail = new UserCoinDetail();
                    $b_detail->source = 'COIN_CONVERT';
                    $b_detail->coin_type = 'ADD';
                    $b_detail->user_coin_id = $g_user->id;
                    $b_detail->coin = $coin;
                    $b_detail->user_coin_convert_log_id = $convert_log->id;
                    if (!$b_detail->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }

                // For Balance update
                $r_user = AppUserBalance::where('app_user_id', auth()->id())->first();
                $r_user->balance -= $request->amount;

                if ($r_user->save()) {
                    $r_b_detail = new AppUserBalanceDetail();
                    $r_b_detail->app_user_balance_id = $r_user->id;
                    $r_b_detail->source = 'COIN_CONVERT';
                    $r_b_detail->balance_type = 'SUB';
                    $r_b_detail->balance = $request->amount;
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
                return redirect()->back()->withInput()->with('error', 'Something went wrong.');
            } else {
                DB::commit();
                return redirect()->route('user.taka_to_coin_convert.history')->with('success', 'Coin convert done successfully.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }
    public function appUserTakaToCoinConvertHistory()
    {
        $datas = UserCoinConvertLog::where('app_user_id', auth()->id())
            ->where('convert_type', 'BALANCE')
            ->orderBy('id', 'DESC')->get();
        return view("frontend.transfer.taka_to_coin_convert_history", compact('datas'));
    }
}
