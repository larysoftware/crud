<?php

declare(strict_types=1);

namespace App\Company\Application\Query;

use App\Company\Domain\Collection\EmployeeViewCollection;
use App\Company\Domain\Repository\EmployeeRepositoryInterface;
use App\Company\Domain\ValueObject\CompanyId;

readonly class GetAllEmployeeQuery
{
    public function __construct(private EmployeeRepositoryInterface $repository)
    {
    }

    public function query(CompanyId $companyId): EmployeeViewCollection
    {
        return $this->repository->findAllByCompanyId($companyId);
    }
}