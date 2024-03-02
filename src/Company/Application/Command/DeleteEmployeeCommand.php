<?php

declare(strict_types=1);

namespace App\Company\Application\Command;

use JsonSerializable;

readonly class DeleteEmployeeCommand implements JsonSerializable
{
    public function __construct(public int $companyId, public int $employeeId)
    {
    }

    /**
     * @return array<string, int>
     */
    public function jsonSerialize(): array
    {
       return [
           'company_id' => $this->companyId,
           'employee_id' => $this->employeeId
       ];
    }
}