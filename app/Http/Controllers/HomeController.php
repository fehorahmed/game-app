<?php

namespace App\Http\Controllers;

use App\Models\HomeSlide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $home_page = true;
        $home_sliders = HomeSlide::where('status',1)->get();
        return view('frontend.home',compact('home_page','home_sliders'));
        // return view('welcome');
    }

}
