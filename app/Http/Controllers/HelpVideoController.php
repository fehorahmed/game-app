<?php

namespace App\Http\Controllers;

use App\Http\Resources\HelpVideoResource;
use App\Models\HelpVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HelpVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = HelpVideo::paginate();

        return view('backend.help_video.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.help_video.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => 'required|string|max:255',
            "url" => 'required|string|max:255',
            "serial" => 'required|numeric',
        ]);

        $data = new HelpVideo();
        $data->title = $request->title;
        $data->url = $request->url;
        $data->serial = $request->serial;

        if ($data->save()) {
            return redirect()->route('config.help-video.index')->with('success', 'Help video added successfully.');
        }
    }

    public function apiGetHelpVideos()
    {
        $datas = HelpVideo::orderBy('serial')->get();
        return response()->json([
            'status' => true,
            'datas' => HelpVideoResource::collection($datas)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(HelpVideo $helpVideo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HelpVideo $helpVideo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HelpVideo $helpVideo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $rules = [
            'id' => 'required|numeric',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first()
            ]);
        }

        $data = HelpVideo::find($request->id);
        if ($data->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.'
            ]);
        }
    }
}
