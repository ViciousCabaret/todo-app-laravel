<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class PasswordType implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $value)) {
            $fail('Password must have at least 8 characters, 1 number, 1 special character and 1 capital number');
        }
    }
}
