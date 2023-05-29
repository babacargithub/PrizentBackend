<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentAbonnementRequest;
use App\Models\Company;
use App\Models\Payment;

class PaymentAbonnementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Payment[]
     */
    public function index()
    {
        //
        return Payment::with("abonnement")->whereRelation("abonnement","company_id","=", Company::requireLoggedInCompany())->get();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param StorePaymentAbonnementRequest $request
     * @return Payment
     */
    public function store(StorePaymentAbonnementRequest $request)
    {
        //
        $payement = new Payment($request->input());
        $payement->save();
        return  $payement;
    }

    /**
     * Display the specified resource.
     *
     * @param Payment $paymentAbonnement
     * @return Payment
     */
    public function show(Payment $paymentAbonnement)
    {
        //
        return $paymentAbonnement;
    }
}
