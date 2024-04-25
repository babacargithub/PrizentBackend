<?php

namespace App\Http\Requests;

use App\Models\Journee;
use App\Models\QrCode;
use App\Rules\Mobile\CompanyHasActiveSubscription;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePointageRequest extends FormRequest
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
            "qr_code_id"=>"required|integer",
            "employe_id"=>["required","integer",
                new CompanyHasActiveSubscription(),
              Rule::unique("pointages")->where(function (Builder $query) {
              $query->where('employe_id', $this->request->get("employe_id",0));
              $query->where("journee_id", Journee::today()->id);
              $query->whereType(QrCode::find($this->request->get("qr_code_id",0))->type);
              })
                ],
            "device"=>"required|array|required_array_keys:uuid"
        ];
    }
  public function messages(): array
  {
      return ["employe_id.unique"=>"Vous avez déjà pointé pour la journée"];
  }
}
