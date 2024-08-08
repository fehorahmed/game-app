<?php

namespace App\Modules\AppUserBalance\Http\Controllers;

use App\Http\Controllers\Controller;
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
}
