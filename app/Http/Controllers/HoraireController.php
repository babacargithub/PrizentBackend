<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHoraireRequest;
use App\Http\Requests\UpdateHoraireRequest;
use App\Models\HoraireEmploye;

class HoraireController extends Controller
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
     * @param  \App\Http\Requests\StoreHoraireRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHoraireRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HoraireEmploye  $horaire
     * @return \Illuminate\Http\Response
     */
    public function show(HoraireEmploye $horaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HoraireEmploye  $horaire
     * @return \Illuminate\Http\Response
     */
    public function edit(HoraireEmploye $horaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHoraireRequest  $request
     * @param  \App\Models\HoraireEmploye  $horaire
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHoraireRequest $request, HoraireEmploye $horaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HoraireEmploye  $horaire
     * @return \Illuminate\Http\Response
     */
    public function destroy(HoraireEmploye $horaire)
    {
        //
    }
}
