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
        //

        $this->authorize("viewAny", Employe::class);
        return EmployeResource::collection(Employe::where('company_id', Company::requireLoggedInCompany()->id)->get());

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
     * @param Employe $employee
     * @return EmployeResource
     */
    public function show(Employe $employee)
    {
        //
        $this->authorize("view", $employee);
       return new EmployeResource($employee);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEmployeeRequest $request
     * @param Employe $employee
     * @return Employe
     */
    public function update(UpdateEmployeeRequest $request, Employe $employee)
    {
        //
        $this->authorize("update",$employee);

         Employe::update($request->input());

         return  $employee;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employe $employee
     * @return Response
     */
    public function destroy(Employe $employee)
    {
        $this->authorize("delete",$employee);
        $employee->delete();
        return  new Response('deleted');
    }
}
