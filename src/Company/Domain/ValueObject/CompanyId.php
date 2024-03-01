<?php

declare(strict_types=1);

namespace App\Company\Domain\ValueObject;

use InvalidArgumentException;

readonly class CompanyId
{
    public function __construct(public int $value)
    {
        if ($this->value < 1) {
            throw new InvalidArgumentException('Company id must be greater than 1');
        }
    }
}