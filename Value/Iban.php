<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Value;

use function Symfony\Component\String\u;

final class Iban
{
    public function __construct(
        private string $iban
    ) {
    }

    public function toString(): string
    {
        return u($this->iban)->upper()->replace(' ', '')->toString();
    }
}