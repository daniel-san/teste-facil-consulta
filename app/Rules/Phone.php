<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Phone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (preg_match('/^\([0-9]{2}\) (9 ?[0-9]{4}|[0-9]{4})-[0-9]{4}$/', $value) > 0) {
            $end = substr($value, 5);

            if ($end == '12345-6789') {
                $fail(__('validation.phone'));
            }

            for ($i = 0; $i <= 9; $i++) {
                if ($end == str_repeat($i, 5) . '-' . str_repeat($i, 4)) {
                    $fail(__('validation.phone'));
                }
            }

            return;
        }

        $fail(__('validation.phone'));
    }
}
