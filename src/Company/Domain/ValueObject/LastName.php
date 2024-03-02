<?php

declare(strict_types=1);

namespace App\Company\Domain\ValueObject;

use InvalidArgumentException;

use function strlen;

readonly class LastName
{
    public function __construct(public string $value)
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException("Last name can't be empty");
        }

        if (strlen($this->value) > 50) {
            throw new InvalidArgumentException("Last name cannot exceed 50 characters");
        }
    }
}