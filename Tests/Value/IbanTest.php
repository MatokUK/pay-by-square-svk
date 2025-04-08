<?php

declare(strict_types=1);

namespace Matok\PayBySquareSvk\Tests\Value;

use Matok\PayBySquare\Value\Iban;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class IbanTest extends TestCase
{
    #[DataProvider('normalizedDataProvider')]
    public function testIbanIsNormalized(string $iban): void
    {
        $iban = new Iban($iban);

        $this->assertStringNotContainsString(' ', $iban->toString());
        $this->assertStringNotContainsString('sk', $iban->toString());
    }

    /**
     * @return array<string, array<int, string>>
     */
    public static function normalizedDataProvider(): array
    {
        return [
            'spaces' => ['SK23 8360 5207 0042 0884 0621'],
            'lowercase' => ['sk23 8360 5207 0042 0884 0621'],            
        ];
    }
}