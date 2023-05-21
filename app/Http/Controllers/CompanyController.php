<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        //

        return CompanyResource::collection(Company::all());
    }



    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return Company
     */
    public function show(Company $company)
    {
        //
        return $company;
    }


}
