<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AppUser\DataTable\AppUsersDataTable;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\CoinManagement\Models\UserCoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppUserController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AppUsersDataTable $dataTable)
    {
        return $dataTable->render("AppUser::app-user-list");
        // return view("AppUser::app-user-list");
    }
    public function apiUserDetails()
    {
        return response()->json([
            'status' => true,
            'data' => auth()->user(),
        ]);
        // return view("AppUser::app-user-list");
    }
    public function apiUserProfileUpdate(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'mobile' => 'required|numeric',
            'referral_id' => 'nullable|string|max:255',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
            ]);
        }
        if ($request->referral_id) {
            $r_count = AppUser::where('user_id', $request->referral_id)->count();
        }

        $user = AppUser::find(auth()->id());
        $user->name = $request->name;
        if (!$user->referral_id) {
            $user->referral_id = $request->referral_id;
        }
        $user->mobile = $request->mobile;
        if ($user->update()) {
            return response()->json([
                'status' => true,
                'data' => auth()->user(),
                'message' => 'Profile updated successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
            ]);
        }


        // return view("AppUser::app-user-list");
    }
    public function apiUserTotalCoin()
    {
        $coin = UserCoin::where('app_user_id', auth()->id())->first()->value('coin') ?? 0;
        return response()->json([
            'status' => true,
            'coin' => $coin,
        ]);
        // return view("AppUser::app-user-list");
    }
}
