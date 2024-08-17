<?php

namespace App\Http\Controllers;

use App\Models\HomeSlide;
use App\Modules\Game\Models\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $home_page = true;
        $home_sliders = HomeSlide::where('status',1)->get();
        $games = Game::where('status',1)->get();
        return view('frontend.home',compact('home_page','home_sliders','games'));
        // return view('welcome');
    }
    public function gameDetail($name){

        $game = Game::where(['name'=>$name])->first();
        return view('frontend.game_detail',compact('game'));
        // return view('welcome');
    }

}
