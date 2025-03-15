<?php

namespace App\Modules\Game\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Models\User;
use App\Modules\AppUser\Http\Resources\AppUserResource;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\CoinManagement\Models\UserCoin;
use App\Modules\CoinManagement\Models\UserCoinDetail;
use App\Modules\Game\Http\Resources\GameSessionDetailResource;
use App\Modules\Game\Models\Game;
use App\Modules\Game\Models\GameSession;
use App\Modules\Game\Models\GameSessionDetail;
use Carbon\Carbon;
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
        $games = Game::all();
        return view('Game::admin.index', compact('games'));
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
    public function edit($id)
    {
        $game = Game::findOrFail($id);
        return view('Game::admin.edit', compact('game'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            "name" => 'required|string',
            "youtube_url" => 'nullable|string|max:255',
            "google_drive_url" => 'nullable|string|max:255',
            "microsoft_drive_url" => 'nullable|string|max:255',
            "status" => 'required|boolean',
            "text" => 'required|string|max:200000'
        ]);

        $game = Game::findOrFail($id);
        $game->name = $request->name;
        $game->youtube_url = $request->youtube_url;
        $game->google_drive_url = $request->google_drive_url;
        $game->microsoft_drive_url = $request->microsoft_drive_url;
        $game->text = $request->text;
        $game->status = $request->status;
        $game->updator = auth()->id();
        if ($game->update()) {
            return redirect()->route('admin.game.index')->with('success', 'Game information update successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function apiGameList()
    {
        $datas = Game::all();
        return response()->json([
            'status' => true,
            'datas' => $datas,

        ], 200);
    }
    public function apiGetActiveGameList()
    {
        $datas = Game::where('status', 1)->get();
        return response()->json([
            'status' => true,
            'datas' =>  GameResource::collection($datas),
        ], 200);
    }

    public function apiGameInit(Request $request)
    {

        $rules = [
            'game_id' => 'required|numeric',
            'host_id' => 'required|numeric',
            'users' => 'required|array',
            'users.*' => 'required|numeric',
            'room_id' => 'required|string|max:255',
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
    public function apiGameWishCoinStore(Request $request)
    {
        $rules = [
            'game_session' => 'required|string',
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ]);
        }
        $user_id = auth()->id();
        //Game Session Check
        $session_ck = GameSession::where(['game_session' => $request->game_session, 'status' => 1])->first();
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
        $g_s_ck = GameSessionDetail::where(['app_user_id' => $user_id, 'game_session_id' => $session_ck->id])->first();
        if (!$g_s_ck) {
            return response()->json([
                'status' => false,
                'message' => 'User not found on this game.'
            ], 401);
        }
        $deduct_amount = $session_ck->board_amount * (5 / 100);
        //Check Coin balance
        $u_coin = UserCoin::where('app_user_id', $user_id)->first();
        if (!$u_coin) {
            return response()->json([
                'status' => false,
                'message' => 'Coin account not found.'
            ], 401);
        }
        if ($u_coin->coin < $deduct_amount) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have enough coin.'
            ], 401);
        }

        $transactionFail = false;
        DB::beginTransaction();
        try {

            $session_detail = new GameSessionDetail();
            $session_detail->game_session_id = $session_ck->id;
            $session_detail->coin_type = 'WISH';
            $session_detail->app_user_id = $user_id;
            //Game Fee

            $session_detail->coin = $deduct_amount;
            // $session_detail->streak = $win_streak;
            $session_detail->remark = 'WISH BUTTON';
            if ($session_detail->save()) {
                $user_c_details = new UserCoinDetail();
                $user_c_details->coin_type = "SUB";
                //Increment Coin
                $u_coin->decrement('coin', $deduct_amount);

                $user_c_details->source = "GAME";
                $user_c_details->user_coin_id = $u_coin->id;
                $user_c_details->coin = $deduct_amount;
                $user_c_details->game_session_detail_id = $session_detail->id;
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
                    'message' => 'Action successfully',
                    'deduct_amount' => $deduct_amount,
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
        $win_streak = 0;
        $win_ck = GameSessionDetail::where('app_user_id', $request->user_id)
            ->where('game_session_id', '!=', $session_ck->id)
            ->latest()->first();
        if ($win_ck) {
            if ($win_ck->coin_type == 'WIN') {
                $win_streak = $win_ck->streak + 1;
            } else {
                $win_streak = 1;
            }
        }

        //dd($win_streak, $win_ck);



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
            $session_update->streak = $win_streak;
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
    public function apiUserGameHistory(Request $request)
    {

        $rules = [
            'game_id' => 'nullable|numeric',
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ]);
        }
        $today = Carbon::today();
        if ($request->game_id) {
            $game_id = $request->game_id;
            $datas = GameSessionDetail::whereHas('gameSession', function ($q) use ($game_id) {
                $q->where('game_id', $game_id);
            })->selectRaw('game_session_id, count(case when coin_type = "WIN" then 1 end) as win_count, sum(case when coin_type = "WIN" then coin else 0 end) as win_coin, sum(case when coin_type = "FEE" then coin else 0 end) as fee_coin')
                ->groupBy('game_session_id')
                ->whereDate('created_at', $today)
                ->where('app_user_id', auth()->id())
                ->orderBy('game_session_id', 'DESC')
                ->get();
        } else {
            $datas = GameSessionDetail::selectRaw('game_session_id, count(case when coin_type = "WIN" then 1 end) as win_count, sum(case when coin_type = "WIN" then coin else 0 end) as win_coin, sum(case when coin_type = "FEE" then coin else 0 end) as fee_coin')
                ->groupBy('game_session_id')
                ->whereDate('created_at', $today)
                ->where('app_user_id', auth()->id())
                ->orderBy('game_session_id', 'DESC')
                ->get();
        }



        // $datas = GameSessionDetail::where('app_user_id', auth()->id())
        //     ->whereDate('created_at', $today)
        //     ->orderBy('id', 'DESC')
        //     ->get();

        return response()->json([
            'status' => true,
            'data' =>  $datas
        ]);
    }
    public function apiGameProfile(Request $request)
    {
        $rules = [
            'game_id' => 'nullable|numeric',
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ]);
        }
        $user = AppUser::find(auth()->id());

        // Get the total count of groups directly using a subquery


        if ($request->game_id) {


            $game_id = $request->game_id;

            $total_game = DB::table(DB::raw("(SELECT COUNT(*) as total
                FROM game_session_details
                JOIN game_sessions ON game_session_details.game_session_id = game_sessions.id
                WHERE game_session_details.app_user_id = " . auth()->id() . "
                AND game_sessions.game_id = " . $game_id . "
                GROUP BY game_session_details.game_session_id) as grouped"))
                ->count();


            $results = GameSessionDetail::select(
                DB::raw('COUNT(*) as total_win_game'),
                DB::raw('SUM(coin) as total_win_sum')
            )->whereHas('gameSession', function ($q) use ($game_id) {
                $q->where('game_id', $game_id);
            })
                ->where('coin_type', 'WIN')->where('app_user_id', auth()->id())->first();

            $current_streak_query =  GameSessionDetail::whereHas('gameSession', function ($q) use ($game_id) {
                $q->where('game_id', $game_id);
            })->where('app_user_id', auth()->id())->latest()->first();
            if ($current_streak_query) {
                $current_streak =  $current_streak_query->streak;
            } else {
                $current_streak =  0;
            }

            $best_win_streak = GameSessionDetail::whereHas('gameSession', function ($q) use ($game_id) {
                $q->where('game_id', $game_id);
            })->where('app_user_id', auth()->id())->max('streak');
        } else {
            $total_game = DB::table(DB::raw("(SELECT COUNT(*) as total
            FROM game_session_details
            WHERE app_user_id = " . auth()->id() . "
            GROUP BY game_session_id) as grouped"))
                ->count();

            $results = GameSessionDetail::select(
                DB::raw('COUNT(*) as total_win_game'),
                DB::raw('SUM(coin) as total_win_sum')
            )->where('coin_type', 'WIN')->where('app_user_id', auth()->id())->first();

            $current_streak_query =  GameSessionDetail::where('app_user_id', auth()->id())->latest()->first();
            if ($current_streak_query) {
                $current_streak =  $current_streak_query->streak;
            } else {
                $current_streak =  0;
            }

            $best_win_streak = GameSessionDetail::where('app_user_id', auth()->id())->max('streak');
        }

        // dd($total_game,auth()->id());

        if ($total_game <= 0) {
            return response()->json([
                'status' => true,
                'total_game' => $total_game,
                'total_win_game' => 0,
                'total_win_sum' => 0,
                'win_rate' => 0,
                'current_streak' => 0,
                'best_win_streak' => 0,
            ]);
        }

        $win_rate = ($results->total_win_game / $total_game) * 100;
        return response()->json([
            'status' => true,
            'total_game' =>  $total_game,
            'total_win_game' =>  $results->total_win_game ?? 0,
            'total_win_sum' =>  $results->total_win_sum ?? 0,
            'win_rate' =>  number_format($win_rate, 2) ?? 0,
            'current_streak' =>  $current_streak ?? 0,
            'best_win_streak' =>  $best_win_streak ?? 0,
        ]);
    }
}
