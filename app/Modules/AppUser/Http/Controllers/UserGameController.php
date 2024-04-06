<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AppUser\Models\AppUserGameSession;
use App\Modules\AppUser\Models\AppUserGameSessionDetail;
use Illuminate\Http\Request;
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

        //Game Session Create
        $session = new AppUserGameSession();
        $session->app_user_id = auth()->id();
        $session->session = Uuid::uuid4()->toString();
        $session->game_name = $request->game_name;
        $session->status = 1;
        $session->init_time = now();
        if ($session->save()) {
            return response()->json([
                'status' => true,
                'session_id' => $session->session,
                'game_name' => $request->game_name
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.'
            ], 401);
        }
    }
    public function apiGameSessionUpdate(Request $request)
    {
        $rules = [
            'session_id' => 'required|string',
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
        $session_ck = AppUserGameSession::where('session', $request->session_id)->first();
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

        //Game Session Update
        $session_update = new AppUserGameSessionDetail();
        $session_update->app_user_game_session_id = $session_ck->id;
        $session_update->coin_type = $request->coin_type;
        $session_update->coin = $request->coin;
        $session_update->remark = $request->remark;
        if ($session_update->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Session update successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.'
            ], 401);
        }
    }
}
