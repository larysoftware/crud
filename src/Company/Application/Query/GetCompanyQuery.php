<?php

declare(strict_types=1);

namespace App\Company\Application\Query;

use App\Company\Application\Dto\GetCompanyByIdRequest;
use App\Company\Domain\Exception\CompanyNotExistException;
use App\Company\Domain\Repository\CompanyRepositoryInterface;
use App\Company\Domain\Entity\CompanyView;
use Exception;

readonly class GetCompanyQuery
{
    public function __construct(public CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * @throws Exception
     * @throws CompanyNotExistException
     */
    public function query(GetCompanyByIdRequest $request): CompanyView
    {
        $result = $this->companyRepository->findById($request->companyId);
        if ($result === null) {
            throw new CompanyNotExistException(
                sprintf(
                    'company_id %d not exist',
                    $request->companyId->value
                )
            );
        }
        return $result;
    }
}