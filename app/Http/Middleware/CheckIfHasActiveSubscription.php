<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckIfHasActiveSubscription
{
    /**
     * Checked that the logged-in user is an administrator.
     *
     * --------------
     * (again - users, not admins).
     *
     * @param Authenticatable|null $user
     * @return bool
     */
    private function checkIfHasActiveSubscription(?Authenticatable $user): bool
    {
        $company = Company::requireLoggedInCompany();
        return $company->hasActiveSubscription();
    }

    /**
     * Answer to unauthorized access request.
     *
     * @return JsonResponse
     */
    private function respondToUnauthorizedRequest(): JsonResponse
    {
        return response()->json(["message"=>"Abonnement expire"])->setStatusCode(403);
    }


    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        if (! $this->checkIfHasActiveSubscription(request()->user()) ){
            return $this->respondToUnauthorizedRequest();
        }

        return $next($request);
    }
}
