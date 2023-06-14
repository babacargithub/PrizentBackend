<?php

namespace App\Http\Controllers;

use App\Events\NouvelAchat;
use App\Http\Requests\StorePaymentAbonnementRequest;
use App\Models\Abonne;
use App\Models\Company;
use App\Models\CompteAbonne;
use App\Models\Payment;
use App\Models\RechargeCompte;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Payment[]
     */
    public function index()
    {
        //
        return Payment::with("abonnement")
            ->whereRelation("abonnement","company_id","=", Company::requireLoggedInCompany())
            ->get();
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
    public function rechargeCompteSuccessCallback(): ?Response
    {
        try {
            $data = json_decode(request()->getContent(), true);
            $clientId = $data['client_id'];
            $montant = $data['montant'];
            /** @var  $compte CompteAbonne */
            $compte = Abonne::with('compte')->find($clientId)->compte;
            $recharge = new RechargeCompte();
            $recharge->montant = $montant;
            $recharge->compteAbonne()->associate($compte);
            $recharge->methode_paiement = "WAVE";
            $recharge->save();
            $compte->augmenterSolde($montant);
            $compte->save();
            NouvelAchat::dispatch( ["id"=>$clientId]);

            Log::info("OK: Payment saved. Request content : " . request()->getContent());
            return new JsonResponse(["status" => "OK: Payment saved"]);


        } catch (\Exception $e) {
            Log::error("unable to save payment, error happened. Request content : ".request()->getContent());
            Log::error($e->getMessage().' '. $e->getTraceAsString());
            return  (new Response())->setStatusCode(500,"Erreur interne");
        }
    }

}
