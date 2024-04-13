<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\QrCode;
use App\Rules\PhoneNumber;
use App\Services\SMSSender;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QrCodeAdminController extends CrudController
{
    //
    public function index()
    {
        return view('admin.qr_codes',[
            "unUsedCount" => QrCode::whereNull("company_id")->count()
        ]);

    } public function link(Request $request)
    {
        $validated = $request->validate([
            "company_telephone"=>["required", new PhoneNumber(false)],
            "qr_code_number"=>["required", "int"],
            "nom"=>"required|string",
            "latitude"=>['numeric'],
            "longitude"=>['numeric'],
            ],
            ["latitude.decimal"=>"Le champ latitude doit être un nombre décimal avec 7 chiffres après la virgule",
            "longitude.decimal"=>"Le champ longitude doit être un nombre décimal avec 7 chiffres après la virgule"],
        );

        $company = Company::whereTelephone($validated["company_telephone"])->first();

        $request->validate(["company_telephone"=> function($attribute,$value, $fail) use ($validated,$company) {
            if (null == $company){
                $fail("Aucune société  avec ce numéro de téléphone");
            }

        },"qr_code_number"=> function($attribute,$value, $fail) use ($validated,$company) {

            if (null == QrCode::whereNumber($validated["qr_code_number"])->first()){
                $fail("Ce numéro de Qr code n'existe pas");
            }
            $qr =  QrCode::whereNumber($validated["qr_code_number"])->whereNotNull('company_id')->first();
            if (null != $qr){
                if ($qr->company_id !== $company->id)
                $fail("Ce qr code est déjà attribué");
            }
        }]);
        $qrCode = QrCode::whereNumber($validated["qr_code_number"])->first();
        $qrCode->update($validated);
        $qrCode->company()->associate($company);
        $qrCode->save();
        return  response()->json(["message"=>"OK"]);

    }

    /** @noinspection UnknownColumnInspection */
    public function generate(Request $request)
    {
        if ($request->isMethod("POST")) {
            $validated = $request->validate(["quantity"=>"required|integer|min:1|max:10",
                "type"=>["required","string", Rule::in(['in','out'])]]);
            $qrCodes = [];
            $biggest = QrCode::max("number");
            $batchStart = $biggest > 0 ? $biggest : 21111;
            for ($i = 0; $i < $validated["quantity"]; $i++) {

                $batchStart++;
                $qrCode = [
                    "number" => $batchStart,
                    "nom"=>"Nom par défaut",
                    "type"=>$validated["type"],
                    "latitude"=>14.1247678,
                    "maximum_distance"=>100,
                    "longitude"=>14.124344];
                $qrCodes[] = $qrCode;
            }
            QrCode::insert($qrCodes);
            return response()->json(["qrCodes" => $qrCodes])->setStatusCode(200);
        }

        return view('admin.qr_codes_generate',[
            "unUsedCount"=>QrCode::whereNull("company_id")->count()
        ]);

    }
    /** @noinspection UnknownColumnInspection */
    public function getUnusedQrCodes($quantity)
    {
        $results = QrCode::whereNull("company_id")->limit($quantity)->pluck("number");
        if ($results->isEmpty()){
            return response("No items found")->setStatusCode(404);
        }
        return $results;

    }
}
