<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Value;

final class ConstantSymbol
{
    private function __construct(private string $symbol)
    {
        // disabled for now, only empty is allowed
    }

    public static function empty(): self
    {
        return new self('');
    }

    public function toString(): string
    {
        return $this->symbol;
    }
}