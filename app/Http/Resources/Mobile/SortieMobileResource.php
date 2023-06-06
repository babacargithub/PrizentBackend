<?php

namespace App\Http\Resources\Mobile;

use App\Models\Journee;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable as JsonSerializableAlias;

/**
 * @property Journee $journee
 * @property integer $ponctualite
 * @property Carbon $scanned_at
 */
class SortieMobileResource extends JsonResource
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
            "journee"=>$this->journee->calendrier->format('D-d-Y'),
            "ferie"=>$this->journee->ferie,
            "scanned_at"=>Carbon::createFromFormat('H:i:s',$this->scanned_at)->format("H:i"),
            "ponctualite"=>$this->ponctualite
            ];
    }
}
