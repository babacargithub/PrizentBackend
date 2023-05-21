<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employe;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //

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
     * @return Employe
     */
    public function show(Employe $employee)
    {
        //
       return $employee;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEmployeeRequest $request
     * @param Employe $employee
     * @return Response
     */
    public function update(UpdateEmployeeRequest $request, Employe $employee)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employe $employee
     * @return Response
     */
    public function destroy(Employe $employee)
    {
        //
    }
}
