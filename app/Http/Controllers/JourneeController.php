<?php /** @noinspection UnknownColumnInspection */

namespace App\Http\Controllers;

use App\Http\Resources\EntreeResource;
use App\Http\Resources\SortieResource;
use App\Models\Company;
use App\Models\Entree;
use App\Models\Journee;
use App\Models\Sortie;
use Carbon\Carbon;

class JourneeController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Carbon $date
     * @return array
     */
    public function pointages($date)
    {
        //
        $date = Carbon::create($date);
        $journee = Journee::where("calendrier",$date->toDateString())->first();
        if ($journee != null) {
            $entrees = EntreeResource::collection(Entree::where("journee_id", $journee->id)->whereRelation("employe", "company_id", "=", Company::requireLoggedInCompany()->id)->get());
            $sorties = SortieResource::collection(Entree::where("journee_id", $journee->id)->whereRelation("employe", "company_id", "=", Company::requireLoggedInCompany()->id)->get());
            return ["journee" => $journee, "sorties" => $sorties, "entrees" => $entrees];
        }
        return [];
    }


}
