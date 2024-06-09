<?php

namespace App\Modules\CoinManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\CoinManagement\DataTables\UserCoinList;
use App\Modules\CoinManagement\Models\UserCoin;
use App\Modules\CoinManagement\Models\UserCoinDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
}
