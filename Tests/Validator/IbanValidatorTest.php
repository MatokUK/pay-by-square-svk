<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Tests;

use Matok\PayBySquare\Validator\IbanValidator;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class IbanValidatorTest extends TestCase
{
    #[DataProvider('validDataProvider')]
    public function testValid(string $iban): void
    {
        $this->assertTrue(IbanValidator::valid($iban));
    }

    public static function validDataProvider(): array
    {
        return [
            ['SK3836555933639179897153'],
            ['SK5964834479379445446985'],
            ['SK1794522769719546571362'],
            ['SK38 3655 5933 6391 7989 7153'],
            ['sk59 6483 4479 3794 4544 6985'],
        ];
    }
}