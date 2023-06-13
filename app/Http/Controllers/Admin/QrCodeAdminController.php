<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\QrCode;
use App\Rules\PhoneNumber;
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
            "latitude"=>['decimal:7'],
            "longitude"=>['decimal:7'],
            ],
            ["latitude.decimal"=>"Le champ latitude doit être un nombre décimal avec 7 chiffres après la virgule",
            "longitude.decimal"=>"Le champ longitude doit être un nombre décimal avec 7 chiffres après la virgule"],
        );

        $company = Company::whereTelephone($validated["company_telephone"])->first();

        $request->validate(["company_telephone"=> function($attribute,$value, $fail) use ($validated,$company) {
            if (null == $company){
                $fail("Aucune société  avec ce numéro de téléphone");
            }

        },"qr_code_number"=> function($attribute,$value, $fail) use ($validated) {

            if (null == QrCode::whereNumber($validated["qr_code_number"])->first()){
                $fail("Ce numéro de Qr code n'existe pas");
            }
            if (null != QrCode::whereNumber($validated["qr_code_number"])->whereNotNull('company_id')->first()){
                $fail("Ce qr code est déjà attribué");
            }
        }]);
        $qrCode = QrCode::whereNumber($validated["qr_code_number"])->first();
        $qrCode->company()->associate($company);
        $qrCode->save();
        return  response()->json(["message"=>"OK"]);

    }

    /** @noinspection UnknownColumnInspection */
    public function generate(Request $request)
    {
        if ($request->isMethod("POST")) {
            $validated = $request->validate(["quantity"=>"required|integer|min:1|max:10",
                "type"=>["required","integer", Rule::in([1,2])]]);
            $qrCodes = [];
            $biggest = QrCode::max("number");
            $batchStart = $biggest > 0 ? $biggest : 21111;
            for ($i = 0; $i < $validated["quantity"]; $i++) {

                $batchStart++;
                $qrCode = [
                    "number" => $batchStart,
                    "nom"=>"Inconnu",
                    "type"=>$validated["type"],
                    "latitude"=>14.1247678,
                    "maximum_distance"=>500,
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
        return QrCode::whereNull("company_id")->limit($quantity)->pluck("number");

    }
}
