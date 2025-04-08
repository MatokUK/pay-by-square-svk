<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Value;

final class DueDate
{
    public function __construct(private string $dueDate)
    {
    }

    public static function today(): DueDate
    {
        return new DueDate(date('Ymd'));
    }

    public function toString(): string
    {
        return $this->dueDate;
    }
}