<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return Company
     */
    public function show(Company $company)
    {
        $company->load("employes");
        $company->load("abonnement");
        $company->load("QrCodes");
        return $company;
    }

    public function update(Company $company, UpdateCompanyRequest $updateCompanyRequest)
    {
        return $company->update($updateCompanyRequest->validated());
    }


}
