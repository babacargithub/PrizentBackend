<?php

namespace App\Http\Requests;

use App\Rules\FormuleLimite;
use App\Rules\PhoneNumber;
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
            "telephone"=>['required','integer', new PhoneNumber(), new FormuleLimite()],
            "sexe"=>"required|string|max:1",
            "horaires"=>"required|array",
            "horaires.*.jour"=>"required|integer|between:1,7",
            "horaires.*.entree"=>"required|date_format:H:i",
            "horaires.*.sortie"=>"required|date_format:H:i",
            "horaires.*.repos"=>"required|boolean",
            "horaires.*.sortie_lendemain"=>"required|boolean",

            //
        ];
    }
}
