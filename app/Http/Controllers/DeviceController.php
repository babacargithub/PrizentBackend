<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Models\Appareil;

class DeviceController extends Controller
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
     * @param  \App\Http\Requests\StoreDeviceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeviceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appareil  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Appareil $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appareil  $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Appareil $device)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDeviceRequest  $request
     * @param  \App\Models\Appareil  $device
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeviceRequest $request, Appareil $device)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appareil  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appareil $device)
    {
        //
    }
}
