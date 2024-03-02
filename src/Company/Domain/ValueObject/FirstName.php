<?php

declare(strict_types=1);

namespace App\Company\Domain\ValueObject;

use InvalidArgumentException;

use function strlen;

readonly class FirstName
{
    public function __construct(public string $value)
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException("First name can't be empty");
        }

        if (strlen($this->value) > 50) {
            throw new InvalidArgumentException("First name cannot exceed 50 characters");
        }
    }
}