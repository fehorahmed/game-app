<?php

namespace App\Modules\AppUserBalance\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AppUserBalance\Models\BalanceTransferLog;
use Illuminate\Http\Request;

class AppUserBalanceController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("AppUserBalance::welcome");
    }
    public function appUserBalanceTransfer()
    {
        return view("frontend.transfer.balance_transfer");
    }
    public function appUserBalanceTransferStore(Request $request)
    {

        $request->validate([
            "user_id" => 'required|numeric',
            "amount" => 'required|numeric',
            "password" => 'required|string|max:20',
        ]);

    }



    public function appUserBalanceTransferHistory()
    {
        $transfers = BalanceTransferLog::all();
        return view("frontend.transfer.balance_transfer_history",compact('transfers'));
    }
}
