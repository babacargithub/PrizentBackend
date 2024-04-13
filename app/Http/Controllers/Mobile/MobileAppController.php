<?php /** @noinspection UnknownColumnInspection */

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePointageRequest;
use App\Http\Resources\Mobile\PointageMobileResource;
use App\Models\Badge;
use App\Models\Employe;
use App\Models\Journee;
use App\Models\Pointage;
use App\Models\QrCode;
use Carbon\Carbon;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

class MobileAppController extends Controller
{
    /**
     * @param $data
     * @return Employe
     */
    public function employe($data)
    {
        return Employe::find($data);
    }

    /**
     * @param $qrCodeNumber
     * @return QrCode|JsonResponse
     */
    public function getQrCode($qrCodeNumber)

    {
        $qrCode = QrCode::whereNumber($qrCodeNumber)->first();
        if ($qrCode == null){
            return  response()->json(["message"=>"QR code introuvable "])->setStatusCode(404);
        }
        return $qrCode;
    }
    /**
     * Display the specified resource.
     *
     * @return array
     */
    public function pointages()
    {
        //
        $dateStart = Carbon::now()->startOfMonth();
        $dateEnd = Carbon::now()->endOfMonth();
        $employe = Employe::requiredLoggedInEmploye();
        $query = Pointage::where("employe_id",$employe->id )
            ->whereRelation("journee","calendrier",">=", $dateStart->toDateString())
            ->whereRelation("journee","calendrier","<=", $dateEnd->toDateString())
            ->orderBy('id',"desc");
        $entrees = PointageMobileResource::collection(
            $query
                ->whereType(Pointage::POINTAGE_SORTIE)
                ->get());
        $sorties = PointageMobileResource::collection(
            $query
                ->whereType(Pointage::POINTAGE_SORTIE)
                ->get());

        return [ "sorties" => $sorties, "entrees" => $entrees];

    }
    /**
     * Display the specified resource.
     *
     * @return Model
     */
    public function pointer(StorePointageRequest $request)
    {
        $qrCode = QrCode::find($request->input("qr_code_id"));
        if ($qrCode->type == QrCode::TYPE_ENTREE){
            $pointage = new Pointage($request->validated());
            $pointage->type = Pointage::POINTAGE_ENTREE;
        }else if ($qrCode->type == QrCode::TYPE_SORTIE){
            $pointage = new Pointage($request->validated());
            $pointage->type = Pointage::POINTAGE_SORTIE;

        }else{
            throw new InvalidArgumentException("Type de qr code inconnu ");
        }
        $journee = Journee::firstOrCreate(["calendrier"=> Carbon::today()->toDateString(), "name" => Carbon::now()->format("d-m-Y")]);
        $pointage->journee()->associate($journee);
        $pointage->scanned_at = Carbon::now()->toTimeString();
        $pointage->calculerPonctualite();
        $pointage->save();

        return $pointage;

    } /**
 * Display the specified resource.
 *
 * @return Model|JsonResponse
 */
    public function pointerUnBadge(Request $request)
    {
         $validated = $request->validate([
            "badge_physique"=>"required|boolean",
             "type"=>["required","integer",
                 Rule::in([1, 2]),
            "employe_id"=>[
                "required",
                "integer",
                Rule::unique('pointages')->where(function (Builder $query) use ($request) {
                    $query->where('employe_id', $request->get("employe_id",0));
                    $query->where("journee_id", Journee::today()->id);
                    $query->where("type", $request->get("type",0) == QrCode::TYPE_ENTREE? Pointage::POINTAGE_ENTREE: Pointage::POINTAGE_SORTIE);
                })
            ],


            ],"pointeur_id"=>["required","integer",
                function (string $attribute, mixed $value, Closure $fail) use ($request) {
                    $pointeur = Employe::requiredLoggedInEmploye();
                    if (! $pointeur->pointeur){
                        $fail("Vous n'êtes pas autorisé à pointer des badges.");

                    }
                    if (! $pointeur->company->hasActiveSubscription()){
                        $fail("Le compte ".$pointeur->company->nom." n'est pas actif. Signalez aux admins.");

                    }

                },

            ],
        ],["employe_id.unique"=>"Cet employé a déjà pointé."]);
         $request->validate(["employe_id"=> function (string $attribute, mixed $value, Closure $fail) use ($request, $validated) {
             $employe_id  = $validated['employe_id'];
             if ($validated["badge_physique"]){

             $badge = Badge::whereNumber($employe_id)->first();
             if ($badge == null){
                 $fail("Ce badge n'existe pas");

             }else{
                 if ($badge->isDisabled()){
                     $fail("Ce badge n'est pas activé !");

                 }else{
                     $employe = $badge->employe;
                     if ($employe == null){
                         $fail("Ce badge n'est attribué à aucun employé ");

                     }

                 }
             }


             }

         },]);

        $type = $validated['type'];
        $qrCode = Employe::requiredLoggedInEmploye()->company->qrCodes()->whereType($type)->first();
        if ($qrCode == null){
            return  response()->json(["message"=>"Aucun QR code crée pour la société. Crée un d'abord"])->setStatusCode(422);
        }


        if ($type == QrCode::TYPE_ENTREE){
            $pointage = new Pointage($request->input());
            $pointage->type = Pointage::POINTAGE_ENTREE;
        }else if ($type == QrCode::TYPE_SORTIE){
            $pointage = new Pointage($request->input());
            $pointage->type = Pointage::POINTAGE_SORTIE;

        }else{
            throw new InvalidArgumentException("Type de qr code inconnu ");
        }
        $journee = Journee::firstOrCreate(["calendrier"=> Carbon::today()->toDateString(), "name" => Carbon::now()->format("d-m-Y")]);
        $pointage->journee()->associate($journee);
        $employe = Employe::whereId($validated["employe_id"])->orWhereRelation("badge","number",$validated["employe_id"])->first();
        $pointage->employe()->associate($employe);
        $pointage->qrCode()->associate($qrCode);
        $pointage->scanned_at = Carbon::now()->toTimeString();
        $pointage->calculerPonctualite();
        $pointage->save();

        return $pointage;

    }
}
