<?php

namespace App\Rules;

use App\Models\Company;
use Closure;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class FormuleLimite implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail): void
    {
        //
        $limite = (int) Company::requireLoggedInCompany()->abonnement->formule->limite;
        if(Company::requireLoggedInCompany()->employes()->count() >= $limite){
            $fail("Vous avez atteint le nombre limite d'employés que vous pouvez créer. \n Veuillez upgrade votre abonnement");
        }

    }
}
