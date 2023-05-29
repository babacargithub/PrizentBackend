<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSortieRequest;
use App\Models\Journee;
use App\Models\Sortie;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SortieController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSortieRequest $request
     * @return Sortie
     * @noinspection UnknownColumnInspection
     */
    public function store(StoreSortieRequest $request)
    {
        $sortie = new Sortie($request->validated());
        $sortie->journee = Journee::where("calendrier","=", Carbon::today()->toDateString());
        $sortie->scanned_at = Carbon::now()->toTimeString();
        $sortie->calculerPonctualite();

        return $sortie;
    }


    /**
     * Remove the specified resource from storage.
     * @param Sortie $sortie
     * @return Response
     */
    public function destroy(Sortie $sortie)
    {
        //
        $sortie->delete();
        return  (new Response("deleted"))->setStatusCode(ResponseAlias::HTTP_NO_CONTENT);
    }
}
