<?php

declare(strict_types=1);

namespace App\Company\Domain\ValueObject;

use InvalidArgumentException;

use JsonSerializable;

readonly class CompanyId implements JsonSerializable
{
    public function __construct(public int $value)
    {
        if ($this->value < 1) {
            throw new InvalidArgumentException('Company id must be greater than 1');
        }
    }

    /**
     * @return array<string, int>
     */
    public function jsonSerialize(): array
    {
        return [
          'company_id' => $this->value
        ];
    }
}