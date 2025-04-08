<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Tests\Value;

use Matok\PayBySquare\Value\PriceEur;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class PriceEurTest extends TestCase
{
    #[DataProvider('invalidDataProvider')]
    public function testPriceIsValidated(int $cents): void
    {
        $this->expectException(\InvalidArgumentException::class);

        PriceEur::fromPriceInCents($cents);
    }

    public static function invalidDataProvider(): array
    {
        return [
            'zero' => [0],
            'negative' => [-1],
        ];
    }

    #[DataProvider('validCentsDataProvider')]
    public function testCreateFromCents(int $cents, string $expected): void
    {
        $price = PriceEur::fromPriceInCents($cents);

        $this->assertSame($expected, $price->toString());
    }

    public static function validCentsDataProvider(): array
    {
        return [
            [1, '0.01 EUR'],
            [50, '0.50 EUR'],
            [99, '0.99 EUR'],
            [200, '2.00 EUR'],
            [205, '2.05 EUR'],
        ];
    }
}