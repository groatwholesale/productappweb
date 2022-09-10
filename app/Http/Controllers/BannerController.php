<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners=Banner::orderBy('step','asc')->get();
        return view('banners.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach($request->images as $index=>$file){
            $imagename = $index.time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/banner/');
            $file->move($destinationPath, $imagename);
            $stepLast=Banner::orderBy('step','desc')->first();
            if(is_null($stepLast)){
                $count=1;
            }
            else{
                $count=$stepLast->step+1;
            }
            $product_images=new Banner;
            $product_images->image=$imagename;
            $product_images->step=$count;
            $product_images->save();
        }
        return response()->json(['status'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('banners.index');
    }

    public function uploadimage(Request $request)
    {
        $orders=$request->order;
        // dd($orders);
        $banners=Banner::orderBy('id','asc')->select('id','step')->get();
        $count=1;
        foreach($orders as $index=>$banner){
            // dd($banner);
            Banner::where(['id'=>$banners[$index]])->update(['step'=>$banner['order']]);
            $count++;
        }        
        return response()->json(['status'=>true]);
    }
}
