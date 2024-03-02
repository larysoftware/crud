<?php

declare(strict_types=1);

namespace App\Company\Application\Dto;

use JsonSerializable;

use function array_filter;

readonly class CreateEmployeeRequest implements JsonSerializable
{
    public function __construct(
        public int $companyId,
        public string $firstName,
        public string $lastName,
        public string $email,
        public ?string $phoneNumber
    ) {
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'company_id' => $this->companyId,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone_number' => $this->phoneNumber
        ]);
    }
}