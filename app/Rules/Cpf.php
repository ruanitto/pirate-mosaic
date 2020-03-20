<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cpf implements Rule
{
    public function passes($attribute, $cpf)
    {
        if (empty($cpf)) {
            return false;
        }

        $cpf = $this->sanitize($cpf);

        if (!$this->isCorrectLength($cpf) || $this->isFakeNumber($cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return ':attribute Inválido!';
    }

    public function sanitize($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        return str_pad($cpf, 11, '0', STR_PAD_LEFT);
    }

    public function isCorrectLength($cpf)
    {
        return strlen($cpf) === 11;
    }

    public function isFakeNumber($cpf)
    {
        return $cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999';
    }
}
