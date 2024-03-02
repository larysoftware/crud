<?php

declare(strict_types=1);

namespace App\Company\Domain\Repository;

use App\Company\Domain\Collection\CompanyViewCollection;
use App\Company\Domain\Entity\Company;
use App\Company\Domain\Entity\CompanyView;
use App\Company\Domain\ValueObject\CompanyId;

interface CompanyRepositoryInterface
{
    public function save(Company $company): CompanyId;
    public function delete(CompanyId $companyId): void;
    public function findById(CompanyId $companyId): ?CompanyView;
    public function findAll(): CompanyViewCollection;
}