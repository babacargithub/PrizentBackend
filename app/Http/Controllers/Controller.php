<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * fetches the required user account of logged in company
     * @return Company
     */
    protected function requireUserAccountOfLoggedInCompany() : Company {

        /** @noinspection UnknownColumnInspection */
        $company = Company::where('user_id',request()->user()->id)->first();
        if ($company == null){
            throw new NotFoundHttpException("Unable to find company with user account id");
        }
        return $company;
    }
}
