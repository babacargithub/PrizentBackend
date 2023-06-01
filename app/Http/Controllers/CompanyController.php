<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Formule;

class CompanyController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return Company
     */
    public function show()
    {
        $company = Company::requireLoggedInCompany();
        $company->load("abonnement");
        $company->load("abonnement.formule");

        return $company;
    } /**
     * Display the specified resource.
     *
     * @return array
 */
    public function abonnementShow()
    {
        $abonnement = Company::requireLoggedInCompany()->abonnement;
        $abonnement->load('formule');
        $formules = Formule::with("features")->get();

        return ["abonnement"=>$abonnement, "formules"=>$formules];
    }

    public function update(Company $company, UpdateCompanyRequest $updateCompanyRequest)
    {
        return $company->update($updateCompanyRequest->input());
    }


}
