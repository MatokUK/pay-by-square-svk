<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Tests\Value;

use Matok\PayBySquare\Value\Message;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class MessageTest extends TestCase
{
    #[DataProvider('invalidDataProvider')]
    public function testMessageIsValidated(string $variableSymbol): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Message($variableSymbol);
    }

    public static function invalidDataProvider(): array
    {
        return [
            'empty' => [''],
        ];
    }
}