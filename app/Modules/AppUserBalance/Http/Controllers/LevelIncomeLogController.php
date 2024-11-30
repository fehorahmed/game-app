<?php

namespace App\Modules\AppUserBalance\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Modules\AppUserBalance\Models\LevelIncomeLog;
use Illuminate\Http\Request;

class LevelIncomeLogController extends Controller
{

    public function apiUserIncome()
    {

        $arr=[];
        for ($i = 1; $i <= 10; $i++){
           $data=  Helper::get_level_gain_with_count($i);
           array_push($arr,$data);
        }

        return response([
            'status' =>true,
            'data'=>$arr
        ]);

    }
    public function apiUserLoss()
    {

        $arr=[];
        for ($i = 1; $i <= 10; $i++){
           $data=  Helper::get_level_gain_with_count($i);
           array_push($arr,$data);
        }

        return response([
            'status' =>true,
            'data'=>$arr
        ]);

    }


}
