<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Value;

final class Message
{
    public function __construct(private string $message)
    {
        $length = strlen($message);
        if ($length === 0) {
            throw new \InvalidArgumentException(sprintf("Message <%s> has invalid length!", $message));
        }

        if ($length > 35) {
            throw new \InvalidArgumentException(sprintf("Message <%s> is too long!", $message));
        }
    }

    public function toString(): string
    {
        return $this->message;
    }
}