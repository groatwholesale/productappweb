<?php

namespace App\Http\Controllers;

use App\Models\Addtocart;
use App\Http\Requests\StoreAddtocartRequest;
use App\Http\Requests\UpdateAddtocartRequest;

class AddtocartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreAddtocartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddtocartRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Addtocart  $addtocart
     * @return \Illuminate\Http\Response
     */
    public function show(Addtocart $addtocart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Addtocart  $addtocart
     * @return \Illuminate\Http\Response
     */
    public function edit(Addtocart $addtocart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAddtocartRequest  $request
     * @param  \App\Models\Addtocart  $addtocart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddtocartRequest $request, Addtocart $addtocart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Addtocart  $addtocart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Addtocart $addtocart)
    {
        //
    }
}
