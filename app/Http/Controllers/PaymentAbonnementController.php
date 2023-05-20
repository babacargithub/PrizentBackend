<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentAbonnementRequest;
use App\Http\Requests\UpdatePaymentAbonnementRequest;
use App\Models\PaymentAbonnement;

class PaymentAbonnementController extends Controller
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
     * @param  \App\Http\Requests\StorePaymentAbonnementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentAbonnementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentAbonnement  $paymentAbonnement
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentAbonnement $paymentAbonnement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentAbonnement  $paymentAbonnement
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentAbonnement $paymentAbonnement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentAbonnementRequest  $request
     * @param  \App\Models\PaymentAbonnement  $paymentAbonnement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentAbonnementRequest $request, PaymentAbonnement $paymentAbonnement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentAbonnement  $paymentAbonnement
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentAbonnement $paymentAbonnement)
    {
        //
    }
}
