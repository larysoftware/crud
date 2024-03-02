<?php

declare(strict_types=1);

namespace App\Company\Application\CommandHandler;

use App\Company\Application\Command\DeleteCompanyCommand;
use App\Company\Domain\Repository\CompanyRepositoryInterface;
use App\Company\Domain\ValueObject\CompanyId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class DeleteCompanyCommandHandler
{
    public function __construct(public CompanyRepositoryInterface $repository)
    {
    }

    public function __invoke(DeleteCompanyCommand $command): void
    {
        $this->repository->delete(new CompanyId($command->companyId));
    }
}