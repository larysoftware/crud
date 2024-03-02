<?php

declare(strict_types=1);

namespace App\Company\Domain\Repository;

use App\Company\Domain\Collection\EmployeeViewCollection;
use App\Company\Domain\Entity\Employee;
use App\Company\Domain\Entity\EmployeeView;
use App\Company\Domain\ValueObject\CompanyId;
use App\Company\Domain\ValueObject\EmployeeId;

interface EmployeeRepositoryInterface
{
    public function save(Employee $employee): EmployeeId;
    public function deleteByCompanyIdAndEmployeeId(CompanyId $companyId, EmployeeId $employeeId): void;
    public function findByCompanyIdAndEmployeeId(CompanyId $companyId, EmployeeId $employeeId): ?EmployeeView;
    public function findAllByCompanyId(CompanyId $companyId): EmployeeViewCollection;
}