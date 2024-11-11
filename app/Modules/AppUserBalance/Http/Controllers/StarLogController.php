<?php

namespace App\Modules\AppUserBalance\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Modules\AppUserBalance\Models\AppUserBalance;
use App\Modules\AppUserBalance\Models\AppUserBalanceDetail;
use App\Modules\AppUserBalance\Models\LevelIncomeLog;
use App\Modules\AppUserBalance\Models\StarLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StarLogController extends Controller
{

    public function userStarBuy()
    {
        $star = auth()->user()->balance->star;

        $amount = Helper::get_star_price($star + 1);

        if (auth()->user()->balance->balance < $amount) {
            return response([
                'status' => false,
                'message' => 'You do not have enough balance.'
            ]);
        }
        if ($star + 1 > 10) {
            return response([
                'status' => false,
                'message' => 'You can\'t buy more then 10 star.'
            ]);
        }

        $ck_level = $star + 1;


        $transactionFail = false;

        DB::beginTransaction();

        try {
            $star_log = new StarLog();
            $star_log->app_user_id = auth()->id();
            $star_log->date = now();
            $star_log->price = $amount;
            $star_log->star_amount = 1;
            $star_log->creator = 'user';
            $star_log->created_by = auth()->id();
            if ($star_log->save()) {
                $app_u_b = AppUserBalance::where('app_user_id', auth()->id())->first();
                $app_u_b->balance -= $amount;
                $app_u_b->star = $app_u_b->star + 1;
                if ($app_u_b->update()) {
                    $b_log = new AppUserBalanceDetail();
                    $b_log->app_user_balance_id = $app_u_b->id;
                    $b_log->source = 'STAR';
                    $b_log->balance_type = 'SUB';
                    $b_log->balance = $amount;
                    $b_log->star_log_id = $star_log->id;
                    if (!$b_log->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }
            } else {
                $transactionFail = true;
            }


            if (auth()->user()->referral_id) {
                $level_user = Helper::level_income_user_check($ck_level);
                $income_percent = Helper::get_level_income_percent($ck_level) ?? 0;

                if ($level_user) {

                    $income_amount = $amount * ($income_percent / 100);

                    if ($level_user->balance->star >= $ck_level) {
                        $l_income = new LevelIncomeLog();
                        $l_income->type = 'GAIN';
                        $l_income->level_number = $ck_level;
                        $l_income->star_buyer_id = auth()->id();
                        $l_income->app_user_id = $level_user->id;
                        $l_income->star_number = $ck_level;
                        $l_income->star_price = $amount;
                        $l_income->amount = $income_amount;
                        $l_income->income_percent = $income_percent;
                        $l_income->star_log_id = $star_log->id;
                        if ($l_income->save()) {
                            $l_u_b = AppUserBalance::where('app_user_id', $level_user->id)->first();
                            $l_u_b->balance += $income_amount;
                            if ($l_u_b->update()) {
                                $l_b_log = new AppUserBalanceDetail();
                                $l_b_log->app_user_balance_id = $l_u_b->id;
                                $l_b_log->source = 'LEVEL';
                                $l_b_log->balance_type = 'ADD';
                                $l_b_log->balance = $income_amount;
                                $l_b_log->level_income_log_id = $l_income->id;
                                if (!$l_b_log->save()) {
                                    $transactionFail = true;
                                }
                            } else {
                                $transactionFail = true;
                            }
                        }
                    }else{
                        $l_income = new LevelIncomeLog();
                        $l_income->type = 'LOSS';
                        $l_income->level_number = $ck_level;
                        $l_income->star_buyer_id = auth()->id();
                        $l_income->app_user_id = $level_user->id;
                        $l_income->star_number = $ck_level;
                        $l_income->star_price = $amount;
                        $l_income->amount = $income_amount;
                        $l_income->income_percent = $income_percent;
                        $l_income->star_log_id = $star_log->id;
                        if (!$l_income->save()) {
                            $transactionFail = true;
                        }
                    }
                }
            }

            if ($transactionFail) {
                DB::rollBack();
                return response([
                    'status' => false,
                    'message' => 'Something went wrong'
                ]);
            } else {
                DB::commit();
                return response([
                    'status' => true,
                    'message' => 'Star claim successfully.'
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function apiStarPrice(Request $request)
    {
        $rules = [
            'star' => 'required|numeric',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
            ]);
        }

        $amount = Helper::get_star_price($request->star);
        return response()->json([
            'status' => true,
            'message' => $amount,
        ]);




    }


    public function apiUserBuyStar()
    {
        $star = auth()->user()->balance->star;

        $amount = Helper::get_star_price($star + 1);

        if (auth()->user()->balance->balance < $amount) {
            return response([
                'status' => false,
                'message' => 'You do not have enough balance.'
            ]);
        }
        if ($star + 1 > 10) {
            return response([
                'status' => false,
                'message' => 'You can\'t buy more then 10 star.'
            ]);
        }

        $ck_level = $star + 1;


        $transactionFail = false;

        DB::beginTransaction();

        try {
            $star_log = new StarLog();
            $star_log->app_user_id = auth()->id();
            $star_log->date = now();
            $star_log->price = $amount;
            $star_log->star_amount = 1;
            $star_log->creator = 'user';
            $star_log->created_by = auth()->id();
            if ($star_log->save()) {
                $app_u_b = AppUserBalance::where('app_user_id', auth()->id())->first();
                $app_u_b->balance -= $amount;
                $app_u_b->star = $app_u_b->star + 1;
                if ($app_u_b->update()) {
                    $b_log = new AppUserBalanceDetail();
                    $b_log->app_user_balance_id = $app_u_b->id;
                    $b_log->source = 'STAR';
                    $b_log->balance_type = 'SUB';
                    $b_log->balance = $amount;
                    $b_log->star_log_id = $star_log->id;
                    if (!$b_log->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }
            } else {
                $transactionFail = true;
            }


            if (auth()->user()->referral_id) {
                $level_user = Helper::level_income_user_check($ck_level);
                $income_percent = Helper::get_level_income_percent($ck_level) ?? 0;

                if ($level_user) {

                    $income_amount = $amount * ($income_percent / 100);

                    if ($level_user->balance->star >= $ck_level) {
                        $l_income = new LevelIncomeLog();
                        $l_income->type = 'GAIN';
                        $l_income->level_number = $ck_level;
                        $l_income->star_buyer_id = auth()->id();
                        $l_income->app_user_id = $level_user->id;
                        $l_income->star_number = $ck_level;
                        $l_income->star_price = $amount;
                        $l_income->amount = $income_amount;
                        $l_income->income_percent = $income_percent;
                        $l_income->star_log_id = $star_log->id;
                        if ($l_income->save()) {
                            $l_u_b = AppUserBalance::where('app_user_id', $level_user->id)->first();
                            $l_u_b->balance += $income_amount;
                            if ($l_u_b->update()) {
                                $l_b_log = new AppUserBalanceDetail();
                                $l_b_log->app_user_balance_id = $l_u_b->id;
                                $l_b_log->source = 'LEVEL';
                                $l_b_log->balance_type = 'ADD';
                                $l_b_log->balance = $income_amount;
                                $l_b_log->level_income_log_id = $l_income->id;
                                if (!$l_b_log->save()) {
                                    $transactionFail = true;
                                }
                            } else {
                                $transactionFail = true;
                            }
                        }
                    }else{
                        $l_income = new LevelIncomeLog();
                        $l_income->type = 'LOSS';
                        $l_income->level_number = $ck_level;
                        $l_income->star_buyer_id = auth()->id();
                        $l_income->app_user_id = $level_user->id;
                        $l_income->star_number = $ck_level;
                        $l_income->star_price = $amount;
                        $l_income->amount = $income_amount;
                        $l_income->income_percent = $income_percent;
                        $l_income->star_log_id = $star_log->id;
                        if (!$l_income->save()) {
                            $transactionFail = true;
                        }
                    }
                }
            }

            if ($transactionFail) {
                DB::rollBack();
                return response([
                    'status' => false,
                    'message' => 'Something went wrong'
                ]);
            } else {
                DB::commit();
                return response([
                    'status' => true,
                    'message' => 'Star claim successfully.'
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response([
                'status' => false,
                'message' => $th->getMessage()
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
    public function show(StarLog $starLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StarLog $starLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StarLog $starLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StarLog $starLog)
    {
        //
    }
}
