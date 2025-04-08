<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Value;

final class VariableSymbol
{
    public function __construct(private string $symbol)
    {
        if (preg_match('/^0+$/', $symbol)) {
            throw new \InvalidArgumentException(sprintf("Variable symbol <%s> is invalid!", $symbol));
        }

        if (!preg_match('/^[0-9][0-9]{0,9}$/', $symbol)) {
            throw new \InvalidArgumentException(sprintf("Variable symbol <%s> is invalid!", $symbol));
        }
    }

    public function toString(): string
    {
        return $this->symbol;
    }
}