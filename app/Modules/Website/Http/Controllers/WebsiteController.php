<?php

namespace App\Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Website\Models\Website;
use App\Modules\Website\Models\WebsiteList;
use App\Modules\Website\Models\WebsiteVisitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            "coin" => 'required|numeric',
            "status" => 'required|boolean',

            'website_name.*' => 'required|string|max:255',
            "url.*" => 'required|string|max:255',
            "time.*" => 'required|numeric',
        ]);
        $website = new Website();
        $website->name = $request->name;
        // $website->url = $request->url;
        $website->coin = $request->coin;
        // $website->time = $request->time;
        $website->status = $request->status;
        if ($website->save()) {

            $counter = 0;
            foreach($request->website_name as $item){
                $website_list = new WebsiteList();
                $website_list->name =  $request->website_name[$counter];
                $website_list->website_id =  $website->id;
                $website_list->url =  $request->url[$counter];
                $website_list->time =  $request->time[$counter];
                $website_list->save();
                $counter++;
            }

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
            "coin" => 'required|numeric',
            "status" => 'required|boolean',

            'website_name.*' => 'required|string|max:255',
            "url.*" => 'required|string|max:255',
            "time.*" => 'required|numeric',
        ]);

        $website->name = $request->name;
        $website->coin = $request->coin;
        $website->status = $request->status;
        if ($website->save()) {
            WebsiteList::where('website_id',$website->id)->delete();

            $counter = 0;
            foreach($request->website_name as $item){
                $website_list = new WebsiteList();
                $website_list->name =  $request->website_name[$counter];
                $website_list->website_id =  $website->id;
                $website_list->url =  $request->url[$counter];
                $website_list->time =  $request->time[$counter];
                $website_list->save();
                $counter++;
            }
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
    public function brawse(Request $request)
    {
        $rules = [
            'url' => 'required|url',
            'time' => 'required|numeric',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return view('errors.404');
        }
        // dd($request->all());
        return view('brawse');
    }
    public function visiting(Request $request)
    {
        $rules = [
            'id' => 'required|numeric',

        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return view('errors.404');
        }
        $website = Website::find($request->id);
        $website_visit_log = WebsiteVisitLog::where(['date'=>now()->format('Y-m-d'),'app_user_id'=>auth()->id(),'website_id'=>$website->id])
        ->first();
        if($website_visit_log){
            return view('errors.404');
        }

        $list = $website->websiteList;

        return view('visiting',compact('website','list'));
    }
}
