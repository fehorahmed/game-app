<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Modules\AppUser\Http\Resources\AppUserResource;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\AppUserGameSession;
use App\Modules\AppUser\Models\AppUserLoginLog;
use App\Modules\AppUser\Models\AppUserReferralRequest;
use App\Modules\AppUser\Models\NormalGameUser;
use App\Modules\CoinManagement\Models\UserCoin;
use App\Modules\CoinManagement\Models\UserCoinDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AppUserAuthController extends Controller
{
    public function appLogin(Request $request)
    {

        $rules = [
            'email' => 'required|email',
            'password' => 'required|string|max:255',
            'game_id' => 'nullable|numeric|max:255'
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
            AppUserLoginLog::storeUserloginlog($user->id, 'APP', $request->game_id);
            $token = $user->createToken('appuser')->plainTextToken;
            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => new AppUserResource($user)
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
                        'message' => 'Referral user over limit. Please use others referral code. '
                    ], 404);
                }
            }
        }
        $transactionFail = false;
        DB::beginTransaction();
        try {

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
                    if (!$referral_request->save()) {
                        $transactionFail = true;
                    }
                }
                $amount = Helper::get_config('registration_bonus') ?? 0;
                $user_coin_create = new UserCoin();
                $user_coin_create->app_user_id = $app_user->id;
                //  $coin_setting
                $user_coin_create->coin = $amount;
                if ($user_coin_create->save()) {
                    $u_c_details = new UserCoinDetail();
                    $u_c_details->source = 'INITIAL';
                    $u_c_details->coin_type = 'ADD';
                    $u_c_details->user_coin_id = $user_coin_create->id;
                    $u_c_details->coin = $amount;
                    if (!$u_c_details->save()) {
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
                    'message' => 'Something went wrong.'
                ], 400);
            } else {
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Registration successfull.'
                ], 200);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 400);
        }
    }
    public function normalGameUserLogin(Request $request)
    {

        $rules = [
            'email' => 'required|email',
            'password' => 'required|string|max:255',
            // 'user_type' => 'required|string',
            // 'game_name' => 'required|in:LUDO,POOL,CARROM,DOTANDBLOCK',
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ], 403);
        }


        $user = NormalGameUser::where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => true,
                    'user' => $user,
                    'message' => 'Login successfull.'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Password not match !!'
                ], 401);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email not registered.'
            ], 401);
        }
    }
    public function normalGameUserRegistration(Request $request)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'game_id' => 'required|numeric',
            'email' => 'required|email|unique:normal_game_users,email',
            'password' => 'required|confirmed|min:6|max:255'
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ], 400);
        }
        //dd($request->all());
        $app_user = new NormalGameUser();
        $app_user->name = $request->name;
        $app_user->email = $request->email;
        $app_user->game_id = $request->game_id;
        $app_user->password = Hash::make($request->password);
        if ($app_user->save()) {
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

    public function redirectToGoogleByApi()
    {

        // return Socialite::driver('google')->stateless()->user();
        return Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
    }
}
