<?php

declare(strict_types=1);

namespace App\Company\Application\CommandHandler;

use App\Company\Application\Command\UpdateCompanyCommand;
use App\Company\Domain\Entity\Company;
use App\Company\Domain\Repository\CompanyRepositoryInterface;
use App\Company\Domain\ValueObject\Address;
use App\Company\Domain\ValueObject\City;
use App\Company\Domain\ValueObject\CompanyId;
use App\Company\Domain\ValueObject\CompanyName;
use App\Company\Domain\ValueObject\Nip;
use App\Company\Domain\ValueObject\PostCode;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UpdateCompanyCommandHandler
{
    public function __construct(private CompanyRepositoryInterface $repository)
    {
    }

    public function __invoke(UpdateCompanyCommand $command)
    {
        $this->repository->update(
            new Company(
                new CompanyId($command->id),
                new CompanyName($command->name),
                new City($command->city),
                new Address($command->address),
                new Nip($command->nip),
                new PostCode($command->postCode)
            )
        );
    }
}