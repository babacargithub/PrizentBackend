<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            "prenom"=>"required|string|min:3",
            "nom"=>"required|string|min:2",
            "email"=>"email|nullable|unique:employes",
            "telephone"=>"integer|unique:employes|min_digits:9|max_digits:9",
            "sexe"=>"required|string|max:1"
            //
        ];
    }
}
