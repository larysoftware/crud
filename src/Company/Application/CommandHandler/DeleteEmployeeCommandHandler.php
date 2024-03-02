<?php

declare(strict_types=1);

namespace App\Company\Application\CommandHandler;

use App\Company\Application\Command\DeleteEmployeeCommand;
use App\Company\Domain\Repository\EmployeeRepositoryInterface;
use App\Company\Domain\ValueObject\CompanyId;
use App\Company\Domain\ValueObject\EmployeeId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class DeleteEmployeeCommandHandler
{

    public function __construct(private EmployeeRepositoryInterface $employeeRepository)
    {
    }

    public function __invoke(DeleteEmployeeCommand $command): void
    {
        $this->employeeRepository->deleteByCompanyIdAndEmployeeId(
            new CompanyId($command->companyId),
            new EmployeeId($command->employeeId)
        );
    }
}