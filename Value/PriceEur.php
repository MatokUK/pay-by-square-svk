<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Value;

final class PriceEur extends Price
{
    public function __construct(string $amount)
    {
        if (preg_match('/^0+(\.0*)?$/', $amount)) {
            throw new \InvalidArgumentException(sprintf("Price <%s> is not valid!", $amount));
        }

        if (!preg_match('/\d+\.\d\d/', $amount)) {
            throw new \InvalidArgumentException(sprintf("Price <%s> is not valid!", $amount));
        }

        $this->currency = 'EUR';
        $this->amount = $amount;
    }
}