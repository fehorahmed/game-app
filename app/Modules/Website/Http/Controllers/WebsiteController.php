<?php

namespace App\Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Website\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{

    public function index(){
        $websites = Website::all();
        return view('Website::admin.website.index',compact('websites'));
    }
    public function create(){

        return view('Website::admin.website.create');
    }

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Website::welcome");
    }
}
