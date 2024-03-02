<?php

declare(strict_types=1);

namespace App\Company\Domain\Entity;

use App\Company\Domain\ValueObject\CompanyId;
use App\Company\Domain\ValueObject\Email;
use App\Company\Domain\ValueObject\EmployeeId;
use App\Company\Domain\ValueObject\FirstName;
use App\Company\Domain\ValueObject\LastName;
use App\Company\Domain\ValueObject\PhoneNumber;

class Employee
{
    public function __construct(
        public ?EmployeeId $employeeId,
        public CompanyId $companyId,
        public FirstName $firstName,
        public LastName $lastName,
        public Email $email,
        public ?PhoneNumber $phoneNumber
    ) {
    }
}