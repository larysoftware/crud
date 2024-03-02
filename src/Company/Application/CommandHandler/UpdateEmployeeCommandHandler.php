<?php

declare(strict_types=1);

namespace App\Company\Application\CommandHandler;

use App\Company\Application\Command\UpdateEmployeeCommand;
use App\Company\Domain\Entity\Employee;
use App\Company\Domain\Repository\EmployeeRepositoryInterface;
use App\Company\Domain\ValueObject\CompanyId;
use App\Company\Domain\ValueObject\Email;
use App\Company\Domain\ValueObject\EmployeeId;
use App\Company\Domain\ValueObject\FirstName;
use App\Company\Domain\ValueObject\LastName;
use App\Company\Domain\ValueObject\PhoneNumber;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UpdateEmployeeCommandHandler
{
    public function __construct(private EmployeeRepositoryInterface $repository)
    {
    }

    public function __invoke(UpdateEmployeeCommand $command): void
    {
        $this->repository->save(
            new Employee(
                new EmployeeId($command->employeeId),
                new CompanyId($command->companyId),
                new FirstName($command->firstName),
                new LastName($command->lastName),
                new Email($command->email),
                $command->phoneNumber ? new PhoneNumber($command->phoneNumber) : null
            )
        );
    }
}