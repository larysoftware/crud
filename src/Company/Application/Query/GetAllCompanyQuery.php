<?php

declare(strict_types=1);

namespace App\Company\Application\Query;

use App\Company\Domain\Collection\CompanyViewCollection;
use App\Company\Domain\Repository\CompanyRepositoryInterface;

readonly class GetAllCompanyQuery
{
    public function __construct(private CompanyRepositoryInterface $companyRepository)
    {
    }

    public function query(): CompanyViewCollection
    {
        return $this->companyRepository->findAll();
    }
}