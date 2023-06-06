<?php

namespace App\Rules\Mobile;

use App\Models\Employe;
use Closure;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CompanyHasActiveSubscription implements InvokableRule
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
        $company = Employe::requiredLoggedInEmploye()->company;
        if(!$company->hasActiveSubscription()){
            $fail("Le compte Prizent de ".$company->nom." n'est pas actif ! Veuillez le signaler aux responsables !");
        }

    }
}
