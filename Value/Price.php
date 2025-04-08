<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Value;

abstract class Price
{
    public readonly string $amount;
    public readonly string $currency;

    public function toString(): string
    {
        return $this->amount.' '.$this->currency;
    }

    public static function fromPriceInCents(int $price): self
    {
        $padded = sprintf("%03d", $price);

        return new static(substr($padded, 0, -2).'.'.substr($padded, 1));
    }
}