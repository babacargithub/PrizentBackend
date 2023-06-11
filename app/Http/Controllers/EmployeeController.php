<?php /** @noinspection UnknownColumnInspection */

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeResource;
use App\Http\Resources\RapportEmployeItemResource;
use App\Models\Company;
use App\Models\Employe;
use App\Models\Entree;
use App\Models\Feature;
use App\Models\Formule;
use App\Models\HoraireEmploye;
use App\Models\Journee;
use App\Models\Sortie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        //todo un comment
//        $this->authorize("viewAny", Employe::class);
        return EmployeResource::collection(Company::requireLoggedInCompany()->employes()->orderBy("prenom")
            ->get());

    }
    /**
     * Display the rankings of the employes.
     *
     */
    public function rankings($dateStart, $dateEnd)
    {
        if (!Company::requireLoggedInCompany()->abonnement->formule->hasFeature(Feature::FEATURE_RANKINGS)){
            $formule = Formule::whereRelation('features',"constant_name",Feature::FEATURE_RANKINGS)->first();
            $formuleName = $formule?->nom;
            return response()->json(["message"=>"Cette fonctionnalité n'est pas incluse dans votre abonnement.".($formuleName != null ? " Elle est disponible à partir de la formule  $formuleName" :'')])->setStatusCode(403);
        }
        $employes = Company::requireLoggedInCompany()->employes;
        $supplementRankings = [];
        $ponctualiteRankings = [];
        foreach ($employes as $employe) {
            $ponctualite = Entree::whereEmployeId($employe->id)
                ->whereHas("journee",function (Builder $query) use ($dateStart, $dateEnd){
                    $query->whereBetween("calendrier", [$dateStart, $dateEnd]); }
                )->sum("ponctualite");
            $supplement = Sortie::whereEmployeId($employe->id)
                ->whereHas("journee",function (Builder $query) use ($dateStart, $dateEnd){
                    $query->whereBetween("calendrier", [$dateStart, $dateEnd]); }
                )->sum("ponctualite");
            $supplementRankings[] = ["employe"=>$employe->full_name, "ponctualite"=>$supplement];
            $ponctualiteRankings[] = ["employe"=>$employe->full_name, "ponctualite"=>$ponctualite];
        }

        $ponctualiteRankings = collect($ponctualiteRankings)->sortByDesc("ponctualite")->values()->map(function (array $item, int $key) {
             $item["position"]= $key+1;
             return $item;
        });
        $supplementRankings = collect($supplementRankings)->sortByDesc("ponctualite")->values()->map(function (array $item, int $key) {
             $item["position"]= $key+1;
             return $item;
        });


        return ["supplementRankings"=>$supplementRankings->values(), "ponctualiteRankings"=>$ponctualiteRankings->values()];

    }
    /**
     * Display a listing of the resource.
     *
     * @return Employe[]
     */
    public function rapport(Employe $employe, $dateStart, $dateEnd)
    {
        //todo un comment
//        $this->authorize("viewAny", Employe::class);
        $entreeQuery = Entree::where("employe_id", $employe->id);
        $entrees = $entreeQuery
            ->whereRelation("employe","company_id","=",Company::requireLoggedInCompany()->id)
            ->whereHas("journee",function (Builder $query) use ($dateStart, $dateEnd){
                $query->whereBetween("calendrier", [$dateStart, $dateEnd]); }
            )->get();
        $sortieQuery = Sortie::where("employe_id", $employe->id);
        $sorties = $sortieQuery
            ->whereRelation("employe","company_id","=",Company::requireLoggedInCompany()->id)
            ->whereHas("journee",function (Builder $query) use ($dateStart, $dateEnd){
                $query->whereBetween("calendrier", [$dateStart, $dateEnd]); }
            )->get();

        $totalRetards = $entreeQuery->whereRelation("employe","company_id","=",Company::requireLoggedInCompany()->id)
            ->whereHas("journee",function (Builder $query) use ($dateStart, $dateEnd){
                $query->whereBetween("calendrier", [$dateStart, $dateEnd]); }
            )->where("ponctualite",'<',0)
            ->sum("ponctualite");
        $totalSupplement = $sortieQuery->whereRelation("employe","company_id","=",Company::requireLoggedInCompany()->id)
            ->whereHas("journee",function (Builder $query) use ($dateStart, $dateEnd){
                $query->whereBetween("calendrier", [$dateStart, $dateEnd]); }
            )->where("ponctualite",'>=',0)
            ->sum("ponctualite");
        $journeesIds = Journee::select('id')->whereBetween("calendrier",[$dateStart,$dateEnd])->whereFerie(false)->get()->toArray();
        $joursAbsentes =  0;
        foreach ($journeesIds as $journeesId) {
            $entree = Entree::where("employe_id", $employe->id)
                ->where("journee_id",intval($journeesId["id"]))->first();
            if ($entree == null){
                $joursAbsentes = $joursAbsentes + 1;
            }
        }
        return [
            "employe"=>new EmployeResource($employe),
            "periode"=>'du '.$dateStart.' au '.$dateEnd,
            "entrees"=>RapportEmployeItemResource::collection($entrees),
            "sorties"=>RapportEmployeItemResource::collection($sorties),
            "retard"=> intval($totalRetards),
            "absence"=>$joursAbsentes,
            "supplement"=>intval($totalSupplement)];

    }

    /**
     * Store a newly created resource in storage.
     * @param StoreEmployeeRequest $request
     * @return Employe
     */
    public function store(StoreEmployeeRequest $request)
    {
        $request->validate($request->rules());
        $employe = new Employe($request->input());
        $company = $this->requireUserAccountOfLoggedInCompany();
        $employe->company()->associate($company);
        $employe->save();
        $employe->horaires()->createMany($request->input()["horaires"]);

        return  $employe;

    }

    /**
     * Display the specified resource.
     *
     * @param Employe $employe
     * @return Employe
     */
    public function show(Employe $employe)
    {
        //todo uncomment
//        $this->authorize("view", $employe);
        $employe->load("horaires");
        $employe->load("appareils");
        $employe->appareils()->get();
        return $employe;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEmployeeRequest $request
     * @param Employe $employe
     * @return Employe
     */
    public function update(UpdateEmployeeRequest $request, Employe $employe)
    {
        //todo uncomment later
//        $this->authorize("update",$employe);
        $employe->update($request->input());

        if (isset($request->input()["horaires"])) {
            $horaires = $request->input()["horaires"];
            foreach ($horaires as $horaire) {
                HoraireEmploye::where("id", $horaire["id"])->update($horaire);
                //          $employe->horaires()->update($horaire);
            }
        }

        return  $employe;

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param Employe $employe
     * @return Response
     */
    public function destroy(Employe $employe)
    {
        //todo un comment later
//        $this->authorize("delete",$employe);
        $employe->delete();
        return  new Response('deleted');
    }

}
