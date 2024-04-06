<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\AppUserGameSession;
use App\Modules\AppUser\Models\AppUserLoginLog;
use App\Modules\AppUser\Models\AppUserReferralRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AppUserAuthController extends Controller
{
    public function appLogin(Request $request)
    {

        $rules = [
            'email' => 'required|email',
            'password' => 'required|string|max:255'
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ]);
        }
        //   dd('asdsad');
        $credentials = $request->only('email', 'password');

        if (Auth::guard('appuser')->attempt($credentials)) {
            $user = Auth::guard('appuser')->user();
            AppUserLoginLog::storeUserloginlog($user->id, 'APP');
            $token = $user->createToken('appuser')->plainTextToken;
            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Email or password not valied.'
        ], 401);
    }
    public function appRegistration(Request $request)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:app_users,email',
            'user_id' => 'required|digits:10|unique:app_users,user_id',
            'password' => 'required|confirmed|min:6|max:255',
            'referral_id' => 'nullable|digits:10'
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ], 403);
        }
        if ($request->referral_id) {
            $ck_referral = AppUser::where('user_id', $request->referral_id)->first();
            if (!$ck_referral) {
                return response()->json([
                    'status' => false,
                    'message' => 'Referral user not found.'
                ], 404);
            }

            $user_ref_ck = AppUser::where('referral_id', $request->referral_id)->get();
            if (count($user_ref_ck) >= 5) {
                if (!$ck_referral) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Referral user over limit. Please use others referral code '
                    ], 404);
                }
            }
        }

        $app_user = new AppUser();
        $app_user->name = $request->name;
        $app_user->email = $request->email;
        $app_user->user_id = $request->user_id;
        $app_user->password = Hash::make($request->password);
        if ($app_user->save()) {

            if ($request->referral_id) {
                $referral_request = new AppUserReferralRequest();
                $referral_request->app_user_id = $app_user->id;
                $referral_request->requested_app_user_id = $ck_referral->id;
                $referral_request->status = 1;
                $referral_request->save();
            }
            return response()->json([
                'status' => true,
                'message' => 'Registration successfull.'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.'
            ], 400);
        }
    }
    public function gameLogin(Request $request)
    {

        $rules = [
            'email' => 'required|email',
            'password' => 'required|string|max:255',
            'user_type' => 'required|string',
            'game_name' => 'required|in:LUDO,POOL,CARROM,DOTANDBLOCK',
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ], 403);
        }
        if ($request->user_type == "APP") {
            $credentials = $request->only('email', 'password');

            if (Auth::guard('appuser')->attempt($credentials)) {
                $user = Auth::guard('appuser')->user();
                AppUserLoginLog::storeUserloginlog($user->id, 'APP', $request->game_name);

                $token = $user->createToken('appuser')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'token' => $token,
                    'user' => $user,
                    'game_name' => $request->game_name
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Email or password not valied.'
            ], 401);
        } elseif ($request->user_type == "NORMAL") {
            return response()->json([
                'status' => false,
                'message' => 'You are select Normal User!!'
            ], 401);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You are not selectiong APP or NORMAL.'
            ], 401);
        }
    }
    public function gameRegistration(Request $request)
    {

        // $rules = [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:app_users,email',
        //     'user_id' => 'required|digits:10|unique:app_users,user_id',
        //     'password' => 'required|confirmed|min:6|max:255'
        // ];
        // $validate = Validator::make($request->all(), $rules);
        // if ($validate->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => $validate->getMessageBag()->first()
        //     ], 400);
        // }

        // $app_user = new AppUser();
        // $app_user->name = $request->name;
        // $app_user->email = $request->email;
        // $app_user->user_id = $request->user_id;
        // $app_user->password = Hash::make($request->password);
        // if ($app_user->save()) {
        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Registration successfull.'
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Something went wrong.'
        //     ], 400);
        // }
    }
}
