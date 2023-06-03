<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckIfHasActiveSubscription
{
    /**
     * Checked that the logged in user is an administrator.
     *
     * --------------
     * VERY IMPORTANT
     * --------------
     * If you have both regular users and admins inside the same table, change
     * the contents of this method to check that the logged in user
     * is an admin, and not a regular user.
     *
     * Additionally, in Laravel 7+, you should change app/Providers/RouteServiceProvider::HOME
     * which defines the route where a logged in user (but not admin) gets redirected
     * when trying to access an admin route. By default it's '/home' but Backpack
     * does not have a '/home' route, use something you've built for your users
     * (again - users, not admins).
     *
     * @param Authenticatable|null $user
     * @return bool
     */
    private function checkIfHasActiveSubscription($user): bool
    {
        $company = Company::where('user_id', $user->id)->first();
        if ($company == null){
            return false;
        }
        return $company->hasActiveSubscription();
    }

    /**
     * Answer to unauthorized access request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondToUnauthorizedRequest(Request $request): \Illuminate\Http\JsonResponse
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
            return $this->respondToUnauthorizedRequest($request);
        }

        return $next($request);
    }
}
