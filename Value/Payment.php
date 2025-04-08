<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Value;

use Matok\PayBySquare\Value\Endroid\QrCode as EndroidQrCode;

final class Payment
{
    public function __construct(private string $payment)
    {        
    }

    public function toQrCode(int $size = 300, int $margin = 10): QrCode
    {
        return new EndroidQrCode($this, $size, $margin);
    }

    public function toString(): string
    {
        return $this->payment;
    }
}