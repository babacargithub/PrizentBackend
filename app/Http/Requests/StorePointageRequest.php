<?php

namespace App\Http\Requests;

use App\Rules\Mobile\CompanyHasActiveSubscription;
use Illuminate\Foundation\Http\FormRequest;

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
            "employe_id"=>["required","integer", new CompanyHasActiveSubscription()],
            "device"=>"required|array|required_array_keys:uuid"
        ];
    }
}
