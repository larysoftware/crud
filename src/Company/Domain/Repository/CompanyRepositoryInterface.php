<?php

declare(strict_types=1);

namespace App\Company\Domain\Repository;

use App\Company\Domain\Entity\Company;
use App\Company\Domain\ValueObject\CompanyId;

interface CompanyRepositoryInterface
{
    public function insert(Company $company): CompanyId;
    public function update(Company $company): void;
}