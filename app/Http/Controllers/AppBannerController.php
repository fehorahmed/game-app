<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\AppBannerResource;
use App\Models\AppBanner;
use Illuminate\Http\Request;

class AppBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = AppBanner::paginate();

        return view('backend.app_banner.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.app_banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => 'required|string|max:255',
            "image" => 'required|image|mimes:png,jpg|max:1024',

        ]);

        $data = new AppBanner();
        $data->title = $request->title;
        $data->created_by = auth()->id();

        if ($request->image) {
            $des = 'home_slider';
            $path =  Helper::saveImage($des, $request->image, 555, 476);
            $data->image = $path;
        }
        if ($data->save()) {
            return redirect()->route('config.app-banner.index')->with('success', 'App Banner added successfully.');
        }
    }

    public function apiGetAppBanners()
    {
      $datas = AppBanner::all();
      return response()->json([
        'status'=>true,
        'datas'=>AppBannerResource::collection($datas)
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppBanner $appBanner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AppBanner $appBanner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppBanner $appBanner)
    {
        //
    }
}
