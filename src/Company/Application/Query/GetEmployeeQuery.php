<?php

declare(strict_types=1);

namespace App\Company\Application\Query;

use App\Company\Application\Dto\EmployeeCompanyRequestQuery;
use App\Company\Domain\Entity\EmployeeView;
use App\Company\Domain\Exception\EmployeeNotExistException;
use App\Company\Domain\Repository\EmployeeRepositoryInterface;
use Exception;

readonly class GetEmployeeQuery
{
    public function __construct(private EmployeeRepositoryInterface $employeeRepository)
    {
    }

    /**
     * @throws Exception
     * @throws EmployeeNotExistException
     */
    public function query(EmployeeCompanyRequestQuery $request): EmployeeView
    {

        $employee = $this->employeeRepository->findByCompanyIdAndEmployeeId(
            $request->companyId,
            $request->employeeId
        );
        if ($employee === null) {
            throw new EmployeeNotExistException;
        }
        return $employee;
    }
}