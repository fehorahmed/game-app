<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Modules\AppUser\Models\AppUserGameSession;
use App\Modules\AppUser\Models\AppUserGameSessionDetail;
use App\Modules\CoinManagement\Models\UserCoin;
use App\Modules\CoinManagement\Models\UserCoinDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class UserGameController extends Controller
{
    public function apiGameInit(Request $request)
    {
        $rules = [
            'game_name' => 'required|in:LUDO,POOL,CARROM,DOTANDBLOCK',
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ]);
        }

        //Check Coin balance
        $u_coin = UserCoin::where('app_user_id', auth()->id())->first();
        if (!$u_coin) {
            return response()->json([
                'status' => false,
                'message' => 'You don\'t have any coin. Please earn coin first.'
            ]);
        }
        if (!Helper::game_init_coin_exist()) {
            return response()->json([
                'status' => false,
                'message' => 'You don\'t have enough coin for play this game. Please earn coin from other options.'
            ]);
        }
        $transactionFail = false;
        DB::beginTransaction();
        try {

            //Game Session Create
            $session = new AppUserGameSession();
            $session->app_user_id = auth()->id();
            $session->session = Uuid::uuid4()->toString();
            $session->game_name = $request->game_name;
            $session->status = 1;
            $session->init_time = now();
            if ($session->save()) {
                $amount = Helper::get_config('game_initialize_coin_amount');
                $session_update = new AppUserGameSessionDetail();
                $session_update->app_user_game_session_id = $session->id;
                $session_update->coin_type = 'FEE';
                $session_update->coin = $amount;
                $session_update->remark = 'Game Initial Fee';
                if ($session_update->save()) {

                    $user_c_details = new UserCoinDetail();
                    $user_c_details->coin_type = "SUB";
                    $u_coin->decrement('coin', $amount);
                    $user_c_details->source = "GAME";
                    $user_c_details->user_coin_id = $u_coin->id;
                    $user_c_details->coin = $amount;
                    $user_c_details->app_user_game_session_detail_id = $session_update->id;
                    if (!$user_c_details->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }

            } else {
                $transactionFail = true;

            }

            if($transactionFail==true){
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong.'
                ]);
            }else{

                DB::commit();
                return response()->json([
                    'status' => true,
                    'session_id' => $session->session,
                    'game_name' => $request->game_name
                ], 200);
            }


        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
    public function apiGameSessionUpdate(Request $request)
    {
        $rules = [
            'game_session' => 'required|string',
            'coin_type' => 'required|in:WIN,LOSS',
            'coin' => 'required|numeric',
            'remark' => 'nullable|string',
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ]);
        }
        //Game Session Check
        $session_ck = AppUserGameSession::where('session', $request->game_session)->first();
        if (!$session_ck) {
            return response()->json([
                'status' => false,
                'message' => 'Session not found .'
            ], 401);
        } else {
            if ($session_ck->status == 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Session no longer active.'
                ], 401);
            }
        }
        // dd(auth()->id());
        //Check Coin balance
        $u_coin = UserCoin::where('app_user_id', auth()->id())->first();
        if (!$u_coin) {
            return response()->json([
                'status' => false,
                'message' => 'Coin account not found.'
            ], 401);
        }

        $transactionFail = false;
        DB::beginTransaction();
        try {
            $session_update = new AppUserGameSessionDetail();
            $session_update->app_user_game_session_id = $session_ck->id;
            $session_update->coin_type = $request->coin_type;
            $session_update->coin = $request->coin;
            $session_update->remark = $request->remark;
            if ($session_update->save()) {
                $user_c_details = new UserCoinDetail();
                if ($request->coin_type == "WIN") {
                    $user_c_details->coin_type = "ADD";
                    $u_coin->increment('coin', $request->coin);
                } elseif ($request->coin_type == "LOSS") {
                    $user_c_details->coin_type = "SUB";
                    $u_coin->decrement('coin', $request->coin);
                }
                $user_c_details->source = "GAME";
                $user_c_details->user_coin_id = $u_coin->id;
                $user_c_details->coin = $request->coin;
                $user_c_details->app_user_game_session_detail_id = $session_update->id;
                if (!$user_c_details->save()) {
                    $transactionFail = true;
                }
            } else {
                $transactionFail = true;
            }


            if ($transactionFail) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong.'
                ], 401);
            } else {
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Session update successfully'
                ], 200);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 401);
        }
        //Game Session Update

    }
}
