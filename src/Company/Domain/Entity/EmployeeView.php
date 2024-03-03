<?php

declare(strict_types=1);

namespace App\Company\Domain\Entity;

use App\Company\Domain\ValueObject\Email;
use App\Company\Domain\ValueObject\EmployeeId;
use App\Company\Domain\ValueObject\FirstName;
use App\Company\Domain\ValueObject\LastName;
use App\Company\Domain\ValueObject\PhoneNumber;
use JsonSerializable;

use function array_filter;

readonly class EmployeeView implements JsonSerializable
{
    public function __construct(
        public EmployeeId $employeeId,
        public FirstName $firstName,
        public LastName $lastName,
        public Email $email,
        public ?PhoneNumber $phoneNumber
    ) {
    }

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'id' => $this->employeeId->value,
            'first_name' => $this->firstName->value,
            'last_name' => $this->lastName->value,
            'email' => $this->email->value,
            'phone_number' => $this->phoneNumber?->value
        ]);
    }
}