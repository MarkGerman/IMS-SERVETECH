<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ISBN implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $value = str_replace(['-', ' '], '', $value);

        // Check for ISBN-10 or ISBN-13 format
        if (preg_match('/^\d{9}[\dX]$/', $value) || preg_match('/^\d{13}$/', $value)) {
            return true;
        }

        return false;
    }

    public function message(): string
    {
        return 'The :attribute is not a valid ISBN. number';
    }   
}
