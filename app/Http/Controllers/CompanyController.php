<?php /** @noinspection UnknownColumnInspection */

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Formule;
use Illuminate\Http\Response;

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
        $company->load("params");
        $company->load("user");

        return $company;
    } /**
     * Display the specified resource.
     *
     * @return array
 */
    public function abonnementShow()
    {
        $abonnement = Company::requireLoggedInCompany()->abonnement;
        if ($abonnement != null){
            $abonnement->load('formule');
        }
        $formules = Formule::with("features")->get();

        return ["abonnement"=>$abonnement, "formules"=>$formules];
    }
    public function pointeurs()
    {
        $company = Company::requireLoggedInCompany();
        return ["pointeurs"=>$company->employes()->get(),
        "users"=>$company->users];

    }

    public function update( UpdateCompanyRequest $updateCompanyRequest)
    {
        $company = Company::requireLoggedInCompany();
         $company->update($updateCompanyRequest->input());
         return $company;
    }

    public function updateParams()
    {
        $company = Company::requireLoggedInCompany();
        $params = request()->input();
                 foreach ($params as $param) {
                     $company->params()->updateExistingPivot($param["id"],["enabled"=>$param["pivot"]["enabled"]]);
                     //          $employe->horaires()->update($horaire);
                 }

        return new Response("OK. Updated");

    }


}
