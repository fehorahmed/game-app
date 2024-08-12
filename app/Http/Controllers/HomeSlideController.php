<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\HomeSlide;
use Illuminate\Http\Request;

class HomeSlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = HomeSlide::paginate();
        // dd($datas);
        return view('backend.slider.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            "title" => 'required|string|max:255',
            "status" => 'required|boolean',
            "image" => 'required|image|mimes:png,jpg|max:1024',
            "content" => 'required|string|max:20000'
        ]);

        $data = new HomeSlide();
        $data->title = $request->title;
        $data->status = $request->status;
        $data->content = $request->content;
        $data->created_by = auth()->id();

        if ($request->image) {
            $des = 'home_slider';
            $path =  Helper::saveImage($des, $request->image, 555, 476);
            $data->image = $path;
        }
        if ($data->save()) {
            return redirect()->route('config.home-slide.index')->with('success', 'Home Slide added successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeSlide $homeSlide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = HomeSlide::findOrFail($id);
        return view('backend.slider.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "title" => 'required|string|max:255',
            "status" => 'required|boolean',
            "image" => 'nullable|image|mimes:png,jpg|max:1024',
            "content" => 'required|string|max:20000'
        ]);

        $data =  HomeSlide::findOrFail($id);
        $data->title = $request->title;
        $data->status = $request->status;
        $data->content = $request->content;
        $data->updated_by = auth()->id();

        if ($request->image) {
            if ($data->image) {
                Helper::deleteFile($data->image);
            }
            $des = 'home_slider';
            $path =  Helper::saveImage($des, $request->image, 555, 476);
            $data->image = $path;
        }
        if ($data->update()) {
            return redirect()->route('config.home-slide.index')->with('success', 'Home Slide added successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeSlide $homeSlide)
    {
        //
    }
}
