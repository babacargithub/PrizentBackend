<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable as JsonSerializableAlias;

class EntreeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializableAlias
     */
    public function toArray($request): array|JsonSerializableAlias|Arrayable
    {
        return ["employe"=>$this->employe->prenom. ' '.$this->employe->nom,
            "scanned_at"=>Carbon::createFromFormat('H:i:s',$this->scanned_at)->format("H:i"),
            "ponctualite"=>$this->ponctualite
            ];
    }
}
