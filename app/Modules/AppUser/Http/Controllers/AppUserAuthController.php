<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AppUserAuthController extends Controller
{
    public function login(Request $request)
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
    public function registration(Request $request)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:app_users,email',
            'user_id' => 'required|digits:10|unique:app_users,user_id',
            'password' => 'required|confirmed|min:6|max:255'
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->getMessageBag()->first()
            ], 400);
        }

        $app_user = new AppUser();
        $app_user->name = $request->name;
        $app_user->email = $request->email;
        $app_user->user_id = $request->user_id;
        $app_user->password = Hash::make($request->password);
        if ($app_user->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Registration successfull.'
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Something went wrong.'
            ], 400);
        }
    }
}
