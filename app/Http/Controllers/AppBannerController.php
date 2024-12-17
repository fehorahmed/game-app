<?php

namespace App\Http\Controllers;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AppBanner $appBanner)
    {
        //
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
