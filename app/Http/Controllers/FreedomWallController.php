<?php

namespace App\Http\Controllers;

use App\Models\FreedomWall;
use Illuminate\Http\Request;

class FreedomWallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('welcome');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FreedomWall  $freedomWall
     * @return \Illuminate\Http\Response
     */
    public function show(FreedomWall $freedomWall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FreedomWall  $freedomWall
     * @return \Illuminate\Http\Response
     */
    public function edit(FreedomWall $freedomWall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FreedomWall  $freedomWall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FreedomWall $freedomWall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FreedomWall  $freedomWall
     * @return \Illuminate\Http\Response
     */
    public function destroy(FreedomWall $freedomWall)
    {
        //
    }
}
