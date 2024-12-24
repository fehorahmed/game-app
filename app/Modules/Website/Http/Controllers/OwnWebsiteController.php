<?php

namespace App\Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Website\Models\OwnWebsite;
use Illuminate\Http\Request;

class OwnWebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $websites = OwnWebsite::all();
        return view('Website::admin.own-website.index', compact('websites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Website::admin.own-website.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            "name" => 'required|string|max:255|unique:own_websites,name',
            "coin" => 'required|numeric',
            "status" => 'required|boolean',
            "url" => 'required|string|max:255',
        ]);
        $website = new OwnWebsite();
        $website->name = $request->name;
        $website->url = $request->url;
        $website->coin = $request->coin;
        // $website->time = $request->time;
        $website->status = $request->status;
        $website->created_by = auth()->id();
        if ($website->save()) {

            return redirect()->route('admin.own.website.list')->with('success', 'Own Website added successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(OwnWebsite $website)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OwnWebsite $website)
    {
        return view('Website::admin.own-website.edit', compact('website'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OwnWebsite $website)
    {
        $request->validate([
            "name" => 'required|string|max:255|unique:own_websites,name,' . $website->id,
            "coin" => 'required|numeric',
            "status" => 'required|boolean',
            "url" => 'required|string|max:255',
        ]);

        $website->name = $request->name;
        $website->url = $request->url;
        $website->coin = $request->coin;
        $website->status = $request->status;
        if ($website->save()) {

            return redirect()->route('admin.own.website.list')->with('success', 'Own Website updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OwnWebsite $ownWebsite)
    {
        //
    }
}
