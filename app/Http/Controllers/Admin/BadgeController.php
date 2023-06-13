<?php

namespace App\Http\Controllers\Admin;

use App\Models\Badge;
use App\Models\Employe;
use App\Models\QrCode;
use App\Rules\PhoneNumber;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BadgeController extends CrudController
{
    //
    public function index()
    {
        $unusedCounts = Badge::whereNull("employe_id")->count();
        return view('admin.badges', ["unused_count" => $unusedCounts
        ]);

    }

    /**
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     * @noinspection UnknownColumnInspection
     */
    public function generate(Request $request)
    {
        if ($request->isMethod("POST")) {
            $validated = $request->validate(["quantity" => "required|integer|max:50|min:1"]);
            $badges = [];
            $biggest = Badge::max("number");
            $biggestBatch = Badge::max("belongs_to_batch");
            $biggestBatch++;
            $batchStart = $biggest > 0 ? $biggest : 11111;
            for ($i = 0; $i <= $validated["quantity"]; $i++) {

                $batchStart++;
                $badge = [
                    "belongs_to_batch" => $biggestBatch,
                    "number" => $batchStart,
                    "last_used_at" => null];
                $badges[] = $badge;
            }
            Badge::insert($badges);
            return response()->json(["badges" => $badges])->setStatusCode(200);
        }

        return view('admin.badges_generate', [
            "unUsedCount"=>QrCode::whereNull("company_id")->count()
        ]);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @noinspection UnknownColumnInspection
     */
    public function linkBadgeWithEmploye(Request $request)
    {
        $validated = $request->validate([
            "employe_telephone" => ["required",new PhoneNumber()],
            "badge_number" => ["required","integer"],
        ]);
        $employe = Employe::whereTelephone($validated["employe_telephone"])->first();

        $request->validate(["employe_telephone"=> function($attribute,$value, $fail) use ($validated,$employe) {
            if (null == $employe){
                $fail("Aucun employé avec ce numéro de téléphone");
            }else{
                if ($employe->badge != null) {
                    $fail("Cet employé a déjà un badge. Il faut l'enlever d'abord");
                }

            }

        },"badge_number"=> function($attribute,$value, $fail) use ($validated) {

            if (null == Badge::whereNumber($validated["badge_number"])->first()){
                $fail("Ce numéro de badge n'existe pas");
            }
            if (null != Badge::whereNumber($validated["badge_number"])->whereNotNull('employe_id')->first()){
                $fail("Ce badge est déjà donné à une autre personne");
            }
        }]);
        $badge = Badge::whereNumber($validated["badge_number"])->first();
        $badge->employe()->associate($employe);
        $badge->save();
        return  response()->json(["message"=>"OK"]);
    }

    /** @noinspection UnknownColumnInspection */
    public function getUnusedBadges($quantity)
    {
        return Badge::whereNull("employe_id")->limit($quantity)->pluck("number");

    }



}
