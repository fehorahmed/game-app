<?php

namespace App\Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Website\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{

    public function index()
    {
        $websites = Website::all();
        return view('Website::admin.website.index', compact('websites'));
    }
    public function create()
    {

        return view('Website::admin.website.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required|string|max:255|unique:websites,name',
            "url" => 'required|string|max:255|unique:websites,url',
            "coin" => 'required|numeric',
            "time" => 'required|numeric',
            "status" => 'required|boolean',
        ]);
        $website = new Website();
        $website->name = $request->name;
        $website->url = $request->url;
        $website->coin = $request->coin;
        $website->time = $request->time;
        $website->status = $request->status;
        if ($website->save()) {
            return redirect()->route('admin.website.list')->with('success', 'Website added successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function edit(Website $website)
    {

        return view('Website::admin.website.edit', compact('website'));
    }
    public function update(Request $request, Website $website)
    {

        $request->validate([
            "name" => 'required|string|max:255|unique:websites,name,' . $website->id,
            "url" => 'required|string|max:255|unique:websites,url,' . $website->id,
            "coin" => 'required|numeric',
            "time" => 'required|numeric',
            "status" => 'required|boolean',
        ]);

        $website->name = $request->name;
        $website->url = $request->url;
        $website->coin = $request->coin;
        $website->time = $request->time;
        $website->status = $request->status;
        if ($website->save()) {
            return redirect()->route('admin.website.list')->with('success', 'Website updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Website::welcome");
    }
}
