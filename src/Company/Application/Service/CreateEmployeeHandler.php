<?php

declare(strict_types=1);

namespace App\Company\Application\Service;

use App\Company\Application\Dto\CreateEmployeeRequest;
use App\Company\Application\Dto\CreateEmployeeResponse;
use App\Company\Domain\Entity\Employee;
use App\Company\Domain\Repository\EmployeeRepositoryInterface;
use App\Company\Domain\ValueObject\CompanyId;
use App\Company\Domain\ValueObject\Email;
use App\Company\Domain\ValueObject\FirstName;
use App\Company\Domain\ValueObject\LastName;
use App\Company\Domain\ValueObject\PhoneNumber;

readonly class CreateEmployeeHandler
{
    public function __construct(private EmployeeRepositoryInterface $repository)
    {
    }

    public function handle(CreateEmployeeRequest $request): CreateEmployeeResponse
    {
        return new CreateEmployeeResponse($this->repository->save(
            new Employee(
                null,
                new CompanyId($request->companyId),
                new FirstName($request->firstName),
                new LastName($request->lastName),
                new Email($request->email),
                $request->phoneNumber !== null ? new PhoneNumber($request->phoneNumber) : null
            )
        )->value);
    }
}