<?php

namespace App\Modules\Game\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\CoinManagement\Models\UserCoin;
use App\Modules\CoinManagement\Models\UserCoinDetail;
use App\Modules\Game\Models\Game;
use App\Modules\Game\Models\GameSession;
use App\Modules\Game\Models\GameSessionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    public function apiGameList()
    {
        $datas = Game::all();
        return response()->json([
            'status' => true,
            'datas' => $datas,

        ], 200);
    }

    public function apiGameInit(Request $request)
    {

        $rules = [
            'game_id' => 'required|numeric',
            'host_id' => 'required|numeric',
            'users' => 'required|array',
            'users.*' => 'required|numeric',
            'room_id' => 'required|numeric',
            'board_amount' => 'required|numeric',
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ]);
        }

        $g_ck = Game::find($request->game_id);
        if (!$g_ck) {
            return response()->json([
                'status' => false,
                'message' => 'Game not found.'
            ]);
        }

        foreach ($request->users as $user1) {
            $u_coin = UserCoin::where('app_user_id', $user1)->first();
            if (!$u_coin) {
                return response()->json([
                    'status' => false,
                    'message' => 'You don\'t have any coin. Please earn coin first.'
                ]);
            }
            if ($u_coin->coin < $request->board_amount) {
                return response()->json([
                    'status' => false,
                    'message' => 'You don\'t have enough coin for play this game. Please earn coin from other options.'
                ]);
            }
        }


        $transactionFail = false;
        DB::beginTransaction();
        try {

            //Game Session Create
            $session = new GameSession();
            $session->host_id = $request->host_id;
            $session->game_session = Uuid::uuid4()->toString();
            $session->room_id = $request->room_id;
            $session->game_id = $request->game_id;
            $session->board_amount = $request->board_amount;
            $session->status = 1;
            $session->init_time = now();
            if ($session->save()) {
                foreach ($request->users as $user) {
                    $session_update = new GameSessionDetail();
                    $session_update->game_session_id = $session->id;
                    $session_update->coin_type = 'FEE';
                    $session_update->coin = $request->board_amount;
                    $session_update->app_user_id = $user;
                    $session_update->remark = 'Game Initial Fee';
                    if ($session_update->save()) {


                        $user_coin = UserCoin::where('app_user_id', $user)->first();

                        $user_c_details = new UserCoinDetail();
                        $user_c_details->coin_type = "SUB";
                        $user_coin->decrement('coin', $request->board_amount);
                        $user_c_details->source = "GAME";
                        $user_c_details->user_coin_id = $user_coin->id;
                        $user_c_details->coin = $request->board_amount;
                        $user_c_details->game_session_detail_id = $session_update->id;
                        if (!$user_c_details->save()) {
                            $transactionFail = true;
                        }
                    } else {
                        $transactionFail = true;
                    }
                }
            } else {
                $transactionFail = true;
            }

            if ($transactionFail == true) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong.'
                ]);
            } else {

                DB::commit();
                return response()->json([
                    'status' => true,
                    'game_session' => $session->game_session,
                    'game_name' => $g_ck->name
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
            'coin_type' => 'required|in:WIN',
            'coin' => 'required|numeric',
            'user_id' => 'required|numeric',
            'remark' => 'nullable|string',
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ]);
        }
        //User check
        $user_ck = AppUser::where('id', $request->user_id)->first();
        if (!$user_ck) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 401);
        }
        //Game Session Check
        $session_ck = GameSession::where('game_session', $request->game_session)->first();
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

        //Check Coin balance
        $u_coin = UserCoin::where('app_user_id', $request->user_id)->first();
        if (!$u_coin) {
            return response()->json([
                'status' => false,
                'message' => 'Coin account not found.'
            ], 401);
        }

        $g_s_ck = GameSessionDetail::where(['app_user_id' => $request->user_id, 'game_session_id' => $session_ck->id])->first();
        if (!$g_s_ck) {
            return response()->json([
                'status' => false,
                'message' => 'User not found on this game.'
            ], 401);
        }

        $transactionFail = false;
        DB::beginTransaction();
        try {
            $session_ck->status = 0;
            if (!$session_ck->update()) {
                $transactionFail = true;
            }

            $session_update = new GameSessionDetail();
            $session_update->game_session_id = $session_ck->id;
            $session_update->coin_type = $request->coin_type;
            $session_update->app_user_id = $request->user_id;


            //Game Fee
            $game_fee = Helper::get_config('game_win_coin_deduct_percentage') ?? 0;
            $deduct_amount = $request->coin * ($game_fee / 100);
            $store_amount = $request->coin - $deduct_amount;

            $session_update->coin = $store_amount;
            $session_update->game_fee = $deduct_amount;
            $session_update->game_fee_percentage = $game_fee;
            $session_update->remark = $request->remark;
            if ($session_update->save()) {
                $user_c_details = new UserCoinDetail();
                if ($request->coin_type == "WIN") {
                    $user_c_details->coin_type = "ADD";
                    //Increment Coin
                    $u_coin->increment('coin', $store_amount);
                }
                $user_c_details->source = "GAME";
                $user_c_details->user_coin_id = $u_coin->id;
                $user_c_details->coin = $store_amount;
                $user_c_details->game_session_detail_id = $session_update->id;
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
                    'message' => 'Session update successfully',
                    'total_win' => $request->coin,
                    'game_fee' => $deduct_amount,
                    'grand_total' => $store_amount
                ], 200);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 401);
        }
    }
}
