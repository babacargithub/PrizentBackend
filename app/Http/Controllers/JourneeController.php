<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJourneeRequest;
use App\Http\Requests\UpdateJourneeRequest;
use App\Models\Journee;

class JourneeController extends Controller
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
     * @param  \App\Http\Requests\StoreJourneeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJourneeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Journee  $journee
     * @return \Illuminate\Http\Response
     */
    public function show(Journee $journee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Journee  $journee
     * @return \Illuminate\Http\Response
     */
    public function edit(Journee $journee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJourneeRequest  $request
     * @param  \App\Models\Journee  $journee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJourneeRequest $request, Journee $journee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Journee  $journee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journee $journee)
    {
        //
    }
}
