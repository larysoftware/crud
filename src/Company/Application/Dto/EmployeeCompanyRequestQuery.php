<?php

declare(strict_types=1);

namespace App\Company\Application\Dto;

use App\Company\Domain\ValueObject\CompanyId;
use App\Company\Domain\ValueObject\EmployeeId;
use JsonSerializable;

readonly class EmployeeCompanyRequestQuery implements JsonSerializable
{
    public function __construct(public CompanyId $companyId, public EmployeeId $employeeId)
    {
    }

    public function jsonSerialize(): array
    {
        return [
          'company_id' => $this->companyId->value,
          'employee_id' => $this->employeeId->value
        ];
    }
}