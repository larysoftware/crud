<?php

declare(strict_types=1);

namespace App\Company\Domain\ValueObject;

use InvalidArgumentException;

use function strlen;
use function ctype_digit;

readonly class Nip
{
    public function __construct(public string $value)
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException("NIP can't be empty");
        }

        if (!ctype_digit($this->value)) {
            throw new InvalidArgumentException("NIP must contain only numeric characters");
        }

        if (strlen($this->value) > 15) {
            throw new InvalidArgumentException("NIP length cannot exceed 15 characters");
        }
    }
}