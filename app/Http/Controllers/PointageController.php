<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePointageRequest;
use App\Http\Requests\UpdatePointageRequest;
use App\Models\Pointage;

class PointageController extends Controller
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
     * @param  \App\Http\Requests\StorePointageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePointageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pointage  $pointage
     * @return \Illuminate\Http\Response
     */
    public function show(Pointage $pointage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pointage  $pointage
     * @return \Illuminate\Http\Response
     */
    public function edit(Pointage $pointage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePointageRequest  $request
     * @param  \App\Models\Pointage  $pointage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePointageRequest $request, Pointage $pointage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pointage  $pointage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pointage $pointage)
    {
        //
    }
}
