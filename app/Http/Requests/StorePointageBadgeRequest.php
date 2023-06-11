<?php

namespace App\Http\Requests;

use App\Models\Employe;
use App\Models\Journee;
use App\Models\QrCode;
use App\Rules\Mobile\CompanyHasActiveSubscription;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePointageBadgeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            // TODO if pointage by badge is allowed
            //TODO verify is pointer is allowed to point
            "employe_id"=>["required","integer",
                new CompanyHasActiveSubscription(),
              Rule::unique($this->request->get("type",0) == QrCode::TYPE_ENTREE? 'entrees': "sorties")->where(function (Builder $query) {
              $query->where('employe_id', $this->request->get("employe_id",0));
              $query->where("journee_id", Journee::today()->id);
              })
                ],
            "type"=>["required","integer",
                Rule::in([1, 2]),

            ],
            ];
    }
  public function messages(): array
  {
      return ["employe_id.unique"=>"Cet employé est déjà pointé !"];
  }
}
