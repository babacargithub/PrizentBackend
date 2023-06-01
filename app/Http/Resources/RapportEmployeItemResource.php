<?php

namespace App\Http\Resources;

use App\Models\Journee;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable as JsonSerializableAlias;

/**
 * @property Journee $journee
 * @property Carbon $scanned_at
 * @property integer $ponctualite
 */
class RapportEmployeItemResource extends JsonResource
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
            "journee"=> $this->journee->calendrier->format('d-m-Y'),
            "scanned_at"=>Carbon::createFromFormat('H:i:s',$this->scanned_at)->format('H:i'),
            "ponctualite"=>$this->ponctualite
            ];
    }
}
