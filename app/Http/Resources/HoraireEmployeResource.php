<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable as JsonSerializableAlias;

/**
 * @property integer $id
 *@property Carbon $entree
 *@property Carbon $sortie
 * @property integer $jour
 * @property integer $repos
 */
class HoraireEmployeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializableAlias
     */
    public function toArray($request): array|JsonSerializableAlias|Arrayable
    {
//        $jours = ["Lundi","Mardi", "Mercredi","Jeudi", "Vendredi","Samedi","Dimanche"];
        return [
            "entree"=>$this->entree->format('H:i'),
            "id"=>$this->id,
            "sortie"=>$this->sortie->format('H:i'),
            "jour"=>$this->jour,
//            "libelle"=> $jours[$this->jour-1],
            "repos"=>(bool) $this->repos,

        ];
    }
}
