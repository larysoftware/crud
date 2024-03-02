<?php

declare(strict_types=1);

namespace App\Company\Domain\ValueObject;

use InvalidArgumentException;

use function strlen;

readonly class PostCode
{
    public function __construct(public string $value)
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException("Postcode can't be empty");
        }

        if (strlen($this->value) > 10) {
            throw new InvalidArgumentException("Postcode length cannot exceed 10 characters");
        }
    }
}