<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PhoneNumber implements InvokableRule
{
    private  $mobile;
    public function __construct($mobile = true)
    {
        $this->mobile = $mobile;
    }

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
        if ($this->mobile) {
            if (!preg_match("/^7[76805][0-9]{7}$/", $value)) {
                $fail("Numéro téléphone invalide !");
            }
        } else {
            if (!preg_match("/^[73][376805][0-9]{7}$/", $value)) {
                $fail("Numéro téléphone invalide !");
            }
        }

    }
}
