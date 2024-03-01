<?php

declare(strict_types=1);

namespace App\Company\Domain\ValueObject;

use InvalidArgumentException;

readonly class Address
{
    public function __construct(public string $value)
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException("Address can't be empty");
        }
    }
}