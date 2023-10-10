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
     * @return array
     */
    public function pointages($date)
    {
        //
        $date = Carbon::create($date);
        $journee = Journee::where("calendrier",$date->toDateString())->first();
        if ($journee != null) {
            $entrees = EntreeResource::collection(Entree::where("journee_id", $journee->id)->whereRelation("employe", "company_id", "=", Company::requireLoggedInCompany()->id)->orderBy('scanned_at')->get());
            $sorties = SortieResource::collection(Sortie::where("journee_id", $journee->id)->whereRelation("employe", "company_id", "=", Company::requireLoggedInCompany()->id)->orderBy('scanned_at')->get());
            return ["journee" => $journee, "sorties" => $sorties, "entrees" => $entrees];
        }
        return [];
    }

    public static function createJourneesDuMois()
    {

// Create a Carbon instance for the first day of the current month
        $startDate = Carbon::now()->startOfMonth();

// Create a Carbon instance for the last day of the current month
        $endDate = Carbon::now()->endOfMonth();


// Loop through the dates from the start to the end of the month
        while ($startDate->lte($endDate)) {
            // Add the current date to the array
            // Move to the next day
            $journee = Journee::where("calendrier", $startDate->toDateString())->first();
            if ($journee == null) {
                Journee::create(["name"=>$startDate->toDateString(), "calendrier"=>$startDate->toDateString()]);

            }
            $startDate->addDay();

        }



    }



}
