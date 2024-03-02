<?php

declare(strict_types=1);

namespace App\Company\Domain\Repository;

use App\Company\Domain\Entity\Employee;
use App\Company\Domain\Entity\EmployeeView;
use App\Company\Domain\ValueObject\EmployeeId;

interface EmployeeRepositoryInterface
{
    public function create(Employee $employee): EmployeeId;
    public function update(Employee $employee): void;
    public function delete(EmployeeId $employeeId): void;
    public function findById(EmployeeId $employeeId): ?EmployeeView;
}