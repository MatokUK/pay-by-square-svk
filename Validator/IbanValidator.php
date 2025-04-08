<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Validator;

final class IbanValidator
{
    public static function valid(string $iban): bool
    {
        $iban = strtoupper(str_replace(' ', '', $iban));

        if (strlen($iban) > 34) {
            return false;
        }

        $check = substr($iban, 4).substr($iban, 0, 4);

        $digits = array_map(
            static fn (string $n): string => ctype_alpha($n) ? (string)(ord($n) - ord('A') + 10) : $n, 
            str_split($check)
        );

        $digits = implode('', $digits);

        return bcmod($digits, '97') === '1';
    }
}