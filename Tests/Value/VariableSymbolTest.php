<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Tests\Value;

use Matok\PayBySquare\Value\VariableSymbol;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class VariableSymbolTest extends TestCase
{
    #[DataProvider('invalidDataProvider')]
    public function testVariableSymbolIsValidated(string $variableSymbol): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new VariableSymbol($variableSymbol);
    }

    /**
     * @return array<string, array<string>>
     */
    public static function invalidDataProvider(): array
    {
        return [
            'not a number' => ['abc'],
            'negative' => ['-4'],
            'zero #1' => ['0'],
            'zero #2' => ['00'],
            'has space' => ['1 2'],
            'more than 10 digits' => ['12345678910'],
        ];
    }
}