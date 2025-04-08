<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Value;

interface QrCode
{
    public function toPng(): string;
}