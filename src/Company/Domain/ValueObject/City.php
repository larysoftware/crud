<?php

declare(strict_types=1);

namespace App\Company\Domain\ValueObject;

use InvalidArgumentException;

readonly class City
{
    public function __construct(public string $city)
    {
        if (empty($this->city)) {
            throw new InvalidArgumentException("City can't be empty");
        }
    }
}