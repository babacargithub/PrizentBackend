<?php /** @noinspection UnknownColumnInspection */

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeResource;
use App\Models\Company;
use App\Models\Employe;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index()
    {
//        $this->authorize("viewAny", Employe::class);
        return Company::requireLoggedInCompany()->employes()->with("devices")->get();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEmployeeRequest $request
     * @return Employe
     */
    public function store(StoreEmployeeRequest $request)
    {
        //
        $employe = new Employe($request->input());
        $company = $this->requireUserAccountOfLoggedInCompany();
        $employe->company()->associate($company);
        $employe->save();
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

            $employe->update($request->input());

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
