<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Value;

abstract class Price
{
    protected readonly string $amount;
    protected readonly string $currency;

    public function toString(): string
    {
        return $this->amount.' '.$this->currency;
    }

    public function getAmount(): string 
    {
        return $this->amount;
    }

    public function getCurrency(): string 
    {
        return $this->currency;
    }

    public static function fromPriceInCents(int $price): self
    {
        $padded = sprintf("%03d", $price);

        return new static(substr($padded, 0, -2).'.'.substr($padded, 1));
    }
}