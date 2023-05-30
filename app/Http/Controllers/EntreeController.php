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
     */
    public function store(StoreEntreeRequest $request)
    {
        $entree = new Entree($request->validated());
        $journee = Journee::firstOrCreate(["calendrier"=> Carbon::today()->toDateString(), "name" => Carbon::now()->format("d-m-Y")]);
        $entree->journee()->associate($journee);
        $entree->scanned_at = Carbon::now()->toTimeString();
        $entree->calculerPonctualite();
        $entree->save();

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
