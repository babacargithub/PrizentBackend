<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class RenouvelerAbonnementRequest extends FormRequest
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
            //The number of the units to be used for the length of the duration (it can be days, or months)
            "nombre_unites"=>'required|integer',
            "telephone"=>['required','integer', new PhoneNumber()],
            "methode_paiement"=>"required|string"
            //
        ];
    }
}
