<?php

declare(strict_types=1);

namespace App\Company\Domain\Repository;

use App\Company\Domain\Entity\Company;

interface CompanyRepositoryInterface
{
    public function insert(Company $company): Company;
    public function update(Company $company): void;
}