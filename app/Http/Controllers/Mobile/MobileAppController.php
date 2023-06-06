<?php /** @noinspection UnknownColumnInspection */

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePointageRequest;
use App\Http\Resources\Mobile\EntreeMobileResource;
use App\Models\Employe;
use App\Models\Entree;
use App\Models\Journee;
use App\Models\QrCode;
use App\Models\Sortie;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
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
     * @param QrCode $qrCode
     * @return QrCode
     */
    public function getQrCode(QrCode $qrCode)
    {
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
            $entrees = EntreeMobileResource::collection(
                Entree::where("employe_id",$employe->id )
                    ->whereRelation("journee","calendrier",">=", $dateStart->toDateString())
                    ->whereRelation("journee","calendrier","<=", $dateEnd->toDateString())
//                    ->join('journees', 'journee.id', '=', 'entrees.journee_id')

                    ->orderBy('id',"desc")->get());
            $sorties = EntreeMobileResource::collection(
                Sortie::where("employe_id",$employe->id )
                    ->whereRelation("journee","calendrier",">=", $dateStart->toDateString())
                    ->whereRelation("journee","calendrier","<=", $dateEnd->toDateString())

                    ->orderBy('id',"desc")->get());

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
        $pointage = new Entree($request->validated());
        }else if ($qrCode->type == QrCode::TYPE_SORTIE){
            $pointage = new Sortie($request->validated());

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
     * @return Model
     */
    public function pointerBadge(StorePointageRequest $request)
    {
        $entree = new Entree($request->validated());
        $journee = Journee::firstOrCreate(["calendrier"=> Carbon::today()->toDateString(), "name" => Carbon::now()->format("d-m-Y")]);
        $entree->journee()->associate($journee);
        $entree->scanned_at = Carbon::now()->toTimeString();
        $entree->calculerPonctualite();
        $entree->save();

        return $entree;

    }


}
