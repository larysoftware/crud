<?php

declare(strict_types=1);

namespace App\Company\Infrastructrue\Repository;

use App\Company\Domain\Entity\Company;
use App\Company\Domain\Exception\NipAlreadyExistsException;
use App\Company\Domain\Repository\CompanyRepositoryInterface;
use App\Company\Domain\ValueObject\CompanyId;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception;

readonly class CompanyRepository implements CompanyRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    /**
     * @throws Exception
     * @throws NipAlreadyExistsException
     */
    public function insert(Company $company): Company
    {
        try {
            $this->connection->executeStatement(
                'INSERT INTO companies (name, city, address, nip, postcode) 
                    VALUES (:name, :city, :address, :nip, :postcode)', [
                    'name' => $company->companyName->value,
                    'city' => $company->city->value,
                    'address' => $company->address->value,
                    'nip' => $company->nip->value,
                    'postcode' => $company->postCode->value,
                ]
            );
            $company->companyId = new CompanyId((int)$this->connection->lastInsertId());
            return $company;
        } catch (UniqueConstraintViolationException) {
            throw new NipAlreadyExistsException(
                sprintf(
                    'nip %s already exists',
                    $company->nip->value
                )
            );
        }
    }

    public function update(Company $company): void
    {
        // TODO: Implement update() method.
    }

    public function delete(CompanyId $companyId): void
    {

    }

    public function findById(CompanyId $companyId): ?Company
    {
        return null;
    }
}