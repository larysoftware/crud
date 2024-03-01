<?php

declare(strict_types=1);

namespace App\Company\Infrastructrue\Repository;

use App\Company\Domain\Entity\Company;
use App\Company\Domain\Repository\CompanyRepositoryInterface;
use App\Company\Domain\ValueObject\CompanyId;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function save(Company $company): Company
    {
        $company->companyId = new CompanyId(12);
        return $company;
    }

    public function delete(CompanyId $companyId): void
    {

    }

    public function findById(CompanyId $companyId): ?Company
    {
        return null;
    }
}