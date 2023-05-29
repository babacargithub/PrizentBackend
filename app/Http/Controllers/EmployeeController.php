<?php /** @noinspection UnknownColumnInspection */

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Company;
use App\Models\Employe;
use App\Models\HoraireEmploye;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use LaravelIdea\Helper\App\Models\_IH_Employe_C;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Employe[]|Collection|_IH_Employe_C
     */
    public function index()
    {
        //todo un comment
//        $this->authorize("viewAny", Employe::class);
        return Company::requireLoggedInCompany()->employes()
            ->get();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEmployeeRequest $request
     * @return Employe
     */
    public function store(StoreEmployeeRequest $request)
    {
        $request->validate($request->rules());
        $employe = new Employe($request->input());

        $company = $this->requireUserAccountOfLoggedInCompany();
        $employe->company()->associate($company);
        $employe->save();
        $employe->horaires()->createMany($request->input()["horaires"]);

        return  $employe;

    }

    /**
     * Display the specified resource.
     *
     * @param Employe $employe
     * @return Employe
     */
    public function show(Employe $employe)
    {
        //todo uncomment
//        $this->authorize("view", $employe);
        $employe->load("horaires");
        $employe->load("appareils");
        $employe->appareils()->get();
        return $employe;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEmployeeRequest $request
     * @param Employe $employe
     * @return Employe
     */
    public function update(UpdateEmployeeRequest $request, Employe $employe)
    {
        //todo uncomment later
//        $this->authorize("update",$employe);
        $request->validate($request->rules());
        $employe->update($request->input());
        $horaires = $request->input()["horaires"];
        foreach ($horaires as $horaire) {
            HoraireEmploye::where("id",$horaire["id"])->update($horaire);
//          $employe->horaires()->update($horaire);
        }


        return  $employe;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employe $employe
     * @return Response
     */
    public function destroy(Employe $employe)
    {
        //todo un comment later
//        $this->authorize("delete",$employe);
        $employe->delete();
        return  new Response('deleted');
    }
}
