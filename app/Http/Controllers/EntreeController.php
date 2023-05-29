<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntreeRequest;
use App\Models\Entree;
use App\Models\Journee;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class EntreeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param StoreEntreeRequest $request
     * @return Entree
     * @noinspection UnknownColumnInspection
     */
    public function store(StoreEntreeRequest $request)
    {
        //
        $entree = new Entree($request->validated());
        $entree->journee = Journee::where("calendrier","=", Carbon::today()->toDateString());
        $entree->scanned_at = Carbon::now()->toTimeString();
        $entree->calculerPonctualite();

        return $entree;
    }

    /**
     * Remove the specified resource from storage.
     * @param Entree $entree
     * @return Response
     */
    public function destroy(Entree $entree)
    {
        //
        $entree->delete();
        return  (new Response("deleted"))->setStatusCode(ResponseAlias::HTTP_NO_CONTENT);
    }
}
