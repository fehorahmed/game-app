<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppUserAuthController extends Controller
{
    public function login(Request $request){

        $rules= [
            'email'=>'required|email',
            'password'=>'required|string|max:255'
        ];
        $validate= Validator::make($request->all(),$rules);
        if($validate->fails()){
            return response()->json([
                'status'=>false,
                'message'=>$validate->getMessageBag()->first()
            ]);
        }
        dd('asdsad');
        $credentials = $request->only('email', 'password');

        if (Auth::guard('appuser')->attempt($credentials)) {
            $user = Auth::guard('appuser')->user();
            $token = $user->createToken('appuser')->plainTextToken;
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
