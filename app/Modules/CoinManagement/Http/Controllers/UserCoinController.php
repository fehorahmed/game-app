<?php

namespace App\Modules\CoinManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CoinManagement\DataTables\UserCoinList;
use App\Modules\CoinManagement\Models\UserCoin;
use App\Modules\CoinManagement\Models\UserCoinDetail;
use Illuminate\Http\Request;

class UserCoinController extends Controller
{

    public function userCoinList(UserCoinList $dataTable)
    {
        return $dataTable->render('CoinManagement::user-coin-list');
    }
    public function userCoinDetails($user_coin)
    {
        $datas = UserCoinDetail::where('user_coin_id', $user_coin)->paginate(1);
        return view('CoinManagement::user-coin-details', compact('datas'));
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
    public function show(UserCoin $userCoin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserCoin $userCoin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserCoin $userCoin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserCoin $userCoin)
    {
        //
    }
}
