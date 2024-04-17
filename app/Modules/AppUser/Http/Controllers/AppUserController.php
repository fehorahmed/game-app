<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AppUser\DataTable\AppUsersDataTable;
use App\Modules\CoinManagement\Models\UserCoin;
use Illuminate\Http\Request;

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