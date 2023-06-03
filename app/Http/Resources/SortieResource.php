<?php

namespace App\Http\Resources;

use App\Models\Employe;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable as JsonSerializableAlias;

/**
 * @property Employe $employe
 * @property integer $ponctualite
 * @property Carbon $scanned_at
 */
class SortieResource extends JsonResource
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
            "employe"=>$this->employe,
            "scanned_at"=>Carbon::createFromFormat("H:m:s", $this->scanned_at)->format('H:m'),
            "ponctualite"=>$this->ponctualite
            ];
    }
}
