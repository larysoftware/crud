<?php

declare(strict_types=1);

namespace App\Company\Domain\Repository;

use App\Company\Domain\Entity\Company;
use App\Company\Domain\Entity\CompanyView;
use App\Company\Domain\ValueObject\CompanyId;

interface CompanyRepositoryInterface
{
    public function create(Company $company): CompanyId;
    public function update(Company $company): void;
    public function delete(CompanyId $companyId): void;
    public function findById(CompanyId $companyId): ?CompanyView;
}