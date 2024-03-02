<?php

declare(strict_types=1);

namespace App\Company\Application\Query;

use App\Company\Application\Dto\CompanyRequestQuery;
use App\Company\Domain\Exception\CompanyNotExistException;
use App\Company\Domain\Repository\CompanyRepositoryInterface;
use App\Company\Domain\Entity\CompanyView;
use Exception;

readonly class GetCompanyQuery
{
    public function __construct(private CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * @throws Exception
     * @throws CompanyNotExistException
     */
    public function query(CompanyRequestQuery $request): CompanyView
    {
        $result = $this->companyRepository->findById($request->companyId);
        if ($result === null) {
            throw new CompanyNotExistException;
        }
        return $result;
    }
}