<?php

declare(strict_types=1);

namespace App\Company\Domain\ValueObject;

use InvalidArgumentException;

use function preg_match;

readonly class PhoneNumber
{
    public function __construct(public string $value)
    {
        if (preg_match('/^\+?[0-9]{1,50}$/', $this->value) !== 1) {
            throw new InvalidArgumentException("Invalid phone number");
        }
    }
}