<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable as JsonSerializableAlias;

/**
 * @property string $prenom
 * @property string $nom
 * @property integer $telephone
 * @property string $email
 * @property array $appareils
 * @property string $sexe
 * @property integer $id
 * @property array $horaires
 */
class EmployeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializableAlias
     */
    public function toArray($request): array|JsonSerializableAlias|Arrayable
    {
        return [
            "fullName"=>$this->prenom. ' '.$this->nom,
            "id"=>$this->id,
            "prenom"=>$this->prenom,
            "nom"=>$this->nom,
            "telephone"=>$this->telephone,
            "email"=>$this->email,
            "sexe"=>$this->sexe,
            "appareils"=>$this->appareils,
            "horaires"=>HoraireEmployeResource::collection($this->horaires)
        ];
    }
}
