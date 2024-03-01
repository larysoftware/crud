<?php

namespace App\Company\Domain\Repository;

use App\Company\Domain\Entity\Company;

interface CompanyRepositoryInterface
{
    public function save(Company $company): Company;
}