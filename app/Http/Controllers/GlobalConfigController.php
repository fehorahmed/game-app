<?php

namespace App\Http\Controllers;

use App\Models\GlobalConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GlobalConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('global-config');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            "application_name" => 'required|string',
            "application_email" => 'nullable|email',
            "company_name" => 'nullable|string',
            "company_address" => 'nullable|string',
            "registration_bonus" => 'required|numeric',
            "game_initialize_coin_amount" => 'required|numeric',
            "game_win_coin_deduct_percentage" => 'required|numeric|max:100',
            "max_referral_user" => 'required|numeric',
        ]);

        $request->request->remove('_token');
        foreach ($request->all() as $key => $value) {
            $this->configUpdate($key, $value);
        }
        return redirect()->back()->with('success', 'Configuration update successfully.');
    }
    /**
     * @param $key
     * @param $value
     *
     * @return bool
     */
    private function configUpdate($key, $value)
    {
        $config = GlobalConfig::where('key', $key)->first();

        if ($config != NULL) {
            $config->value = is_array($value) ? implode(',', $value) : $value;

            return $config->save();
        } else {
            $config = new GlobalConfig();

            $config->key = $key;

            $config->value = is_array($value) ? implode(',', $value) : $value;

            return $config->save();
        }
    }


    public function getConfigByApi(Request $request){
        $rules = [
            'key'=>'required|string|max:255',
        ];

        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()){
            return response()->json([
                'status'=>false,
                'message'=>$validation->errors()->first()
            ]);
        }
        $config = GlobalConfig::where('key', $request->key)->first();
        if($config){
            return response()->json([
                'status'=>true,
                'value'=>$config->value
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'Value not found for this key.'
        ]);


    }
}
