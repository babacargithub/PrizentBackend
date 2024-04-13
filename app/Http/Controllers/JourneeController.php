<?php /** @noinspection UnknownColumnInspection */

namespace App\Http\Controllers;

use App\Http\Resources\PointageResource;
use App\Models\Company;
use App\Models\Journee;
use App\Models\Pointage;
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
            $sortieQuery = Pointage::where("journee_id", $journee->id)
                ->whereHas("employe", function ($query) {
                    $query->where("company_id", Company::requireLoggedInCompany()->id);
                })
                ->orderBy('scanned_at');
            $entreeQuery = clone  $sortieQuery;

            $sorties = PointageResource::collection($sortieQuery->sortie()->get());
               $entrees = PointageResource::collection($entreeQuery->entree()->get());
            return ["journee" => $journee, "sorties" => $sorties, "entrees" => $entrees];
        }
        return [];
    }

    /** @noinspection PhpUnused */
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
