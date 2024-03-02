<?php

declare(strict_types=1);

namespace App\Company\Domain\ValueObject;

use InvalidArgumentException;

use function strlen;
use function filter_var;

readonly class Email
{
    public function __construct(public string $value)
    {
        if (strlen($this->value) > 255) {
            throw new InvalidArgumentException("Email cannot exceed 50 characters");
        }

        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format");
        }
    }
}