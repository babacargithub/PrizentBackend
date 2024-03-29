<?php

namespace App\Http\Controllers;

use App\Http\Requests\RenouvelerAbonnementRequest;
use App\Models\Abonnement;
use App\Models\Formule;
use App\Models\Payment;
use App\Rules\PhoneNumber;
use App\Services\CommercialCommissionCalculator;
use App\Services\SMSSender;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
            "methode_paiement"=>["required",function($value, $attribute, $fail){

                if (strtolower($value) == "om"){
                    $fail("Le paiement par Orange Money n'est pas encore activé. Veuillez utiliser Wave");
                }else if (strtolower($value) == "cash"){
                    $fail("Le paiement par Cash n'est pas encore autorisé. Veuillez utiliser Wave");
                }
            }],
            "nombre_unites"=>"required|numeric",
            "telephone"=>["required", new PhoneNumber()],
        ]);
        $formule  =  $abonnement->formule;
        $nombre_unites  = $validated["nombre_unites"];
        $montant =  (integer)($formule->prix * (integer) $nombre_unites);
        if (Str::lower($validated["methode_paiement"]) == Str::lower(Payment::PAYEMENT_METHOD_WAVE)){
            $launch_url = $this->getWavePaymentUrl($montant, [
                "abonnement_id"=>$abonnement->id,
                "nombre_unites"=>$validated["nombre_unites"],
                "montant"=>$montant,
                "phone_number"=>$validated["telephone"]
            ]);
            $message = "Vous avez initié un paiement Wave sur Prizent. Cliquez sur le lien suivant pour valider l'opération $launch_url";
            SMSSender::sendSms($validated["telephone"], $message);
            return response()->json(["message"=>"INITIATED","launch_url"=>$launch_url]);
        }else if ($validated["methode_paiement"] == Payment::PAYMENT_METHOD_OM) {
            return  response()->json(["message"=>"Paiement par Orange Money pas encore fonctionnel pour le moment. Choisissez Wave"])->setStatusCode(422);
        }
        return  response()->json(["Initiated"=>"OK"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function renouvelerAbonnementCallbackWithWave(Request $request, CommercialCommissionCalculator $commercialCommissionCalculator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data["abonnement_id"]) || !isset($data["nombre_unites"])){
            Log::alert("content of data",["data_logged"=>$data]);
            Log::alert("abonnement_id or nombres unite not set");
            Log::alert($request->getContent());
            return new JsonResponse(["message"=>"something went wrong"], 200);
        }
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
            $abonnement->date_expir = $abonnement->date_expir->addMonths($nombre_unites);
        }elseif ($unite =="semaine"){
            $abonnement->date_expir = $abonnement->date_expir->addWeeks($nombre_unites);
        }
        $abonnement->save();
        $message = "Votre réabonnement à la formule ".$abonnement->formule->nom." a été effectué avec succès. Il est valable jusqu'au ".$abonnement->date_expir->format('d-m-Y H\\h:i:s')."\n Prizent vous remercie ! ";
        SMSSender::sendSms($data["phone_number"],$message);
        //TODO broadcast later
//        $pusherBroadcaster->broadcast(["abonnements"],"renewed");
        $commercial = $abonnement->company->commercial;
        if ($commercial != null){
            $commercialCommissionCalculator->calculateCommissions($commercial, $abonnement);
        }

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
            "error_url" => "https://client.prizent.tech",
            "success_url" =>"https://client.prizent.tech",
        ];
        $response = Http::post($url,$data);
        $res = json_decode($response->body(),true);
        return $res["wave_launch_url"]?? null;
    }

    private function triggerOMPayement( array $data): void
    {
        $formule = Formule::find($data["formule_id"]);
        $montant = (integer) ($formule->prix * (integer)$data ["nombre_unites"]);
        $data["montant"] = $montant;
        $response = Http::post('https://golobone.net/paymenent/om/for_prizent', $data);

        $response["message"];
    }
}
