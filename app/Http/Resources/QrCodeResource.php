<?php

namespace App\Http\Resources;

use App\Models\Feature;
use App\Models\QrCode;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class QrCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {

        /** @var QrCode $this */
        return [
            "id"=>$this->id,
            "nom"=>$this->nom,
            "latitude"=>$this->latitude,
            "longitude"=>$this->longitude,
            "type"=>(string)$this->type,
            "disabled"=>$this->disabled,
            "number"=>$this->number,
            "should_check_gps_location"=>$this->company->abonnement->formule->hasFeature(Feature::FEATURE_LOCATION_CONSTRAINT),
            "qr_code_url"=>"https://app.prizent.pro/qr_code/".$this->id

        ];
    }
}
