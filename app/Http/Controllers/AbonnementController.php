<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbonnementRequest;
use App\Http\Requests\RenouvelerAbonnementRequest;
use App\Models\Abonnement;
use App\Models\Company;
use App\Models\Formule;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class AbonnementController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param AbonnementRequest $request
     * @return JsonResponse
     */
    public function abonnerRequest(AbonnementRequest $request)
    {
        $data = $request->input();
        //TODO change later and make dynamic
        $nombre_unites  = 1;
        $formule_id  = $data["formule_id"];
        $company_id  = Company::requireLoggedInCompany()->id;
        $data = [
            "formule_id"=>$formule_id,
            "company_id"=>$company_id,
            "nombre_unites"=>$nombre_unites];
        $this->saveAbonnerRequest($data);

        // TODO INITIATE payment WAVE or OM
        return response()->json(["message"=>"INITIATED"]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return JsonResponse
     */
    public function saveAbonnerRequest($data)
    {
        $nombre_unites  = $data["nombre_unites"];
        $formule_id  = $data["formule_id"];
        $company_id  = $data["company_id"];
        $company = Company::find($company_id);
        $formule = Formule::find($formule_id);
        $abonnement = new Abonnement();
        $abonnement->company()->associate($company);
        $abonnement->formule()->associate($formule);
        $unite = $formule->unite;
        if ($unite == "mois"){
            $abonnement->date_expir = Carbon::now()->addMonths($nombre_unites);
        }elseif ($unite =="semaine"){
            $abonnement->date_expir = Carbon::now()->addWeeks($nombre_unites);
        }
        $abonnement->save();
        // TODO Broadcast event new abonnement
        return response()->json(["message"=>"OK"]);

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Abonnement $abonnement
     * @param RenouvelerAbonnementRequest $request
     * @return JsonResponse
     */
    public function renouveler(Abonnement $abonnement, RenouvelerAbonnementRequest $request)
    {
        //TODO authorisation
        $data = $request->input();
        $nombre_unites  = $data["nombre_unites"];
        $telephone  = $data["telephone"];
        $unite = $abonnement->formule->unite;
        // TODO INITIATE payment WAVE or OM
        $this->renouvelerEnregistrer($abonnement, $data);
        return response()->json(["message"=>"INITIATED"]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Abonnement $abonnement
     * @param $data
     * @return JsonResponse
     */
    public function renouvelerEnregistrer(Abonnement $abonnement,  $data)
    {
        $payment = new Payment();
        $payment->abonnement()->associate($abonnement);
        //TODO change these 2 values
        $payment->paye_par = "";
        $payment->montant = 2000;
        $payment->save();

        $nombre_unites  = $data["nombre_unites"];
        $unite = $abonnement->formule->unite;
        if ($unite == "mois"){
            $abonnement->date_expir->addMonths($nombre_unites);
        }elseif ($unite =="semaine"){
            $abonnement->date_expir = $abonnement->date_expir->addWeeks($nombre_unites);
        }
        $abonnement->save();

        return response()->json(["message"=>"INITIATED"]);

    }
}
