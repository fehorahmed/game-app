<?php

namespace App\Modules\TokenManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenManagementController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("TokenManagement::welcome");
    }
}
