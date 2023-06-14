<?php

namespace App\Http\Controllers;

use App\Http\Requests\RenouvelerAbonnementRequest;
use App\Models\Abonnement;
use App\Models\Payment;
use App\Rules\PhoneNumber;
use App\Services\SMSSender;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class AbonnementController extends Controller
{

//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param AbonnementRequest $request
//     * @return JsonResponse
//     */
//    public function abonnerRequest(AbonnementRequest $request)
//    {
//        $validated = $request->validate([
//            "formule_id"=>"required|integer",
//            "nombre_unites"=>"required|numeric",
//            "telephone"=>["required", new PhoneNumber()],
//        ]);
//        $nombre_unites  = $validated["nombre_unites"];
//        $formule  = Formule::find($validated["formule_id"]);
//        $company  = Company::requireLoggedInCompany();
//        $company_id  = $company->id;
//        $data = [
//            "formule_id"=>$formule->id,
//            "company_id"=>$company_id,
//            "nombre_unites"=>$nombre_unites];
//
//        $launch_url = $this->getWavePaymentUrl($company,  $data);
//        $message = "Vous avez initié un paiement Wave sur Prizent. Cliquez sur le lien suivant pour valider l'opération $launch_url";
//        SMSSender::sendSms($data["telephone"], $message);
//        return response()->json(["message"=>"INITIATED"]);
//
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @return JsonResponse
//     */
//    public function saveAbonnerRequestCallback($data)
//    {
//        $nombre_unites  = $data["nombre_unites"];
//        $formule_id  = $data["formule_id"];
//        $company_id  = $data["company_id"];
//        $company = Company::find($company_id);
//        $formule = Formule::find($formule_id);
//        $abonnement = new Abonnement();
//        $abonnement->company()->associate($company);
//        $abonnement->formule()->associate($formule);
//        $unite = $formule->unite;
//        if ($unite == "mois"){
//            $abonnement->date_expir = Carbon::now()->addMonths($nombre_unites);
//        }elseif ($unite =="semaine"){
//            $abonnement->date_expir = Carbon::now()->addWeeks($nombre_unites);
//        }
//        $abonnement->save();
//          $pusherBroadcaster->broadcast(["abonnements"],"renewed");
//        return response()->json(["message"=>"OK"]);
//
//    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Abonnement $abonnement
     * @param RenouvelerAbonnementRequest $request
     * @return JsonResponse
     */
    public function renouvelerInitiateRequest(Abonnement $abonnement, RenouvelerAbonnementRequest $request)
    {
        $validated = $request->validate([
            "methode_paiement"=>["required", Rule::in(["OM","WAVE","CASH"])],
            "nombre_unites"=>"required|numeric",
            "telephone"=>["required", new PhoneNumber()],
        ]);
        $formule  =  $abonnement->formule;
        $nombre_unites  = $validated["nombre_unites"];
        $montant =  (integer)($formule->prix * (integer) $nombre_unites);
        if ($validated["methode_paiement"] == Payment::PAYEMENT_METHOD_WAVE){
            $launch_url = $this->getWavePaymentUrl($montant, [
                "abonnement_id"=>$abonnement->id,
                "nombre_unites"=>$validated["nombre_unites"],
                "montant"=>$montant
            ]);
            $message = "Vous avez initié un paiement Wave sur Prizent. Cliquez sur le lien suivant pour valider l'opération $launch_url";
            SMSSender::sendSms($validated["telephone"], $message);
            return response()->json(["message"=>"INITIATED","launch_url"=>$launch_url]);
        }else if ($validated["methode_paiement"] == Payment::PAYMENT_METHOD_OM) {
            // TODO finish the job
            $this->triggerOMPayement($montant, $validated);
            return  response()->json(["message"=>"OK"]);
        }
        return  response()->json(["Initiated"=>"OK"]);
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param PusherBroadcaster $pusherBroadcaster
     * @return JsonResponse
     */
    public function renouvelerAbonnementCallbackWithWave(Request $request, PusherBroadcaster $pusherBroadcaster)
    {
        $data = $request->input("data");
        $abonnement = Abonnement::find($data["abonnement_id"]);
        $payment = new Payment();
        $payment->abonnement()->associate($abonnement);
        $montant = $data["montant"];
        $payment->paye_par = "WAVE";
        $payment->montant = $montant;
        $payment->save();

        $nombre_unites  = $data["nombre_unites"];
        $unite = $abonnement->formule->unite;
        if ($unite == "mois"){
            $abonnement->date_expir->addMonths($nombre_unites);
        }elseif ($unite =="semaine"){
            $abonnement->date_expir = $abonnement->date_expir->addWeeks($nombre_unites);
        }
        $abonnement->save();
        $pusherBroadcaster->broadcast(["abonnements"],"renewed");

        return response()->json(["message"=>"INITIATED"]);

    }

    public   function getWavePaymentUrl($montant,  array $data): ?string
    {
        //
        $url = "https://golobone.net/go_travel_v4/public/api/mobile/digipress_wave_url";
        $data = [
            "amount"=> $montant,
            "currency" => "XOF",
            "client_reference"=>json_encode(["type"=>"prizent","data"=>json_encode($data)]),
            "error_url" => "https://prizent.sn",
            "success_url" =>"https://prizent.sn",
        ];
        $response = Http::post($url,$data);
        $res = json_decode($response->body(),true);
        return $res["wave_launch_url"]?? null;
    }

    private function triggerOMPayement(int $montant, array $data)
    {
        // TODO OM payment
    }
}
