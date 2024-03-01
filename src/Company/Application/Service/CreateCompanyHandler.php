<?php

declare(strict_types=1);

namespace App\Company\Application\Service;

use App\Company\Application\Dto\CreateCompanyRequest;
use App\Company\Application\Dto\CreateCompanyResponse;
use App\Company\Domain\Entity\Company;
use App\Company\Domain\Repository\CompanyRepositoryInterface;
use App\Company\Domain\ValueObject\Address;
use App\Company\Domain\ValueObject\City;
use App\Company\Domain\ValueObject\CompanyName;
use App\Company\Domain\ValueObject\Nip;
use App\Company\Domain\ValueObject\PostCode;

readonly class CreateCompanyHandler
{
    public function __construct(private CompanyRepositoryInterface $repository)
    {
    }

    public function handle(CreateCompanyRequest $request): CreateCompanyResponse
    {
        return new CreateCompanyResponse($this->repository->save(
                new Company(
                    null,
                    new CompanyName($request->name),
                    new City($request->city),
                    new Address($request->address),
                    new Nip($request->nip),
                    new PostCode($request->postCode)
                )
            )->companyId->value
        );
    }
}