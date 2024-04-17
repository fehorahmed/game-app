<?php

namespace App\Http\Controllers;

use App\Models\GlobalConfig;
use Illuminate\Http\Request;

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
}
