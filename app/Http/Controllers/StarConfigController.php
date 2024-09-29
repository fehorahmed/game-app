<?php

namespace App\Http\Controllers;

use App\Models\StarConfig;
use Illuminate\Http\Request;

class StarConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('star-config');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "zero_start_withdraw" => 'required|numeric',
            "one_star_withdraw" => 'required|numeric',
            "two_star_withdraw" => 'required|numeric',
            "three_star_withdraw" => 'required|numeric',
            "four_star_withdraw" => 'required|numeric',
            "five_star_withdraw" => 'required|numeric',
            "six_star_withdraw" => 'required|numeric',
            "seven_star_withdraw" => 'required|numeric',
            "eight_star_withdraw" => 'required|numeric',
            "nine_star_withdraw" => 'required|numeric',
            "ten_star_withdraw" => 'required|numeric',

            "one_star_price" => 'required|numeric',
            "two_star_price" => 'required|numeric',
            "three_star_price" => 'required|numeric',
            "four_star_price" => 'required|numeric',
            "five_star_price" => 'required|numeric',
            "six_star_price" => 'required|numeric',
            "seven_star_price" => 'required|numeric',
            "eight_star_price" => 'required|numeric',
            "nine_star_price" => 'required|numeric',
            "ten_star_price" => 'required|numeric',

        ]);

        $request->request->remove('_token');
        foreach ($request->all() as $key => $value) {
            $this->configUpdate($key, $value);
        }
        return redirect()->back()->with('success', 'Configuration update successfully.');
    }

    private function configUpdate($key, $value)
    {
        $config = StarConfig::where('key', $key)->first();

        if ($config != NULL) {
            $config->value = is_array($value) ? implode(',', $value) : $value;

            return $config->save();
        } else {
            $config = new StarConfig();

            $config->key = $key;

            $config->value = is_array($value) ? implode(',', $value) : $value;

            return $config->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StarConfig $starConfig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StarConfig $starConfig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StarConfig $starConfig)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StarConfig $starConfig)
    {
        //
    }
}
