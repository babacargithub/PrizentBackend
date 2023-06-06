<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MobileAppRequest
{
    /**
     * @param Request $request
     * @return bool
     */
    private function checkIfHeadersAreSet(Request $request): bool
    {
        $employe_id = $request->header('Employe-id');
        if ($employe_id == null){
            return false;
        }
        return true;
    }

    /**
     * Answer to unauthorized access request.
     *
     * @return JsonResponse
     */
    private function respondToUnauthorizedRequest(): JsonResponse
    {
        return response()->json(["message"=>"Unauthorized for employe"])->setStatusCode(401);
    }


    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     * @noinspection PhpMissingParamTypeInspection
     */
    public function handle($request, Closure $next): mixed
    {
        if (! $this->checkIfHeadersAreSet($request) ){
            return $this->respondToUnauthorizedRequest();
        }

        return $next($request);
    }
}
