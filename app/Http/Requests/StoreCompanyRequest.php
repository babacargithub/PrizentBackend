<?php

namespace App\Http\Requests;

use App\Policies\RoleNames;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // TODO change authorisaitons
       return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "telephone"=>["unique:companies", new PhoneNumber()],
            "email"=>"email|unique:companies"
            //
        ];
    }
}
