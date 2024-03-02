<?php

declare(strict_types=1);

namespace App\Company\Domain\ValueObject;

use InvalidArgumentException;

use function strlen;

readonly class City
{
    public function __construct(public string $value)
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException("City can't be empty");
        }

        if (strlen($this->value) > 255) {
            throw new InvalidArgumentException("City cannot exceed 255 characters");
        }
    }
}