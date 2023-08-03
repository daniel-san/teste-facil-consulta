<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cpf implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = preg_replace('/[^0-9]/', '', $value);
        $value = str_pad($value, 11, '0', STR_PAD_LEFT);

        if (strlen($value) !== 11) {
            $fail(__('validation.cpf'));
        } elseif ($value == '00000000000' || $value == '11111111111' || $value == '22222222222' || $value == '33333333333' || $value == '44444444444' || $value == '55555555555' || $value == '66666666666' || $value == '77777777777' || $value == '88888888888' || $value == '99999999999') {
            $fail(__('validation.cpf'));
        } else {
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $value[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($value[$c] != $d) {
                    $fail(__('validation.cpf'));
                }
            }
        }
    }
}
