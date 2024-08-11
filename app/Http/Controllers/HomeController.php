<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $home_page = true;
        return view('frontend.home',compact('home_page'));
        // return view('welcome');
    }

}
