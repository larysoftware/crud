<?php

declare(strict_types=1);

namespace App\Company\Infrastructrue\Repository;

use App\Company\Domain\Entity\Company;
use App\Company\Domain\Entity\CompanyView;
use App\Company\Domain\Exception\CompanyIdCantBeNullException;
use App\Company\Domain\Exception\NipAlreadyExistsException;
use App\Company\Domain\Repository\CompanyRepositoryInterface;
use App\Company\Domain\ValueObject\Address;
use App\Company\Domain\ValueObject\City;
use App\Company\Domain\ValueObject\CompanyId;
use App\Company\Domain\ValueObject\CompanyName;
use App\Company\Domain\ValueObject\Nip;
use App\Company\Domain\ValueObject\PostCode;
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
    public function insert(Company $company): CompanyId
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
            return new CompanyId((int)$this->connection->lastInsertId());
        } catch (UniqueConstraintViolationException) {
            throw new NipAlreadyExistsException(
                sprintf(
                    'nip %s already exists',
                    $company->nip->value
                )
            );
        }
    }

    /**
     * @throws Exception
     * @throws CompanyIdCantBeNullException
     * @throws NipAlreadyExistsException
     */
    public function update(Company $company): void
    {
        if ($company->companyId === null) {
            throw new CompanyIdCantBeNullException("company id can't be null");
        }
        try {
            $this->connection->executeStatement(
                'UPDATE companies SET name = :name, city = :city, address = :address, nip = :nip, postcode = :postcode WHERE id = :id',
                [
                    'id' => $company->companyId->value,
                    'name' => $company->companyName->value,
                    'city' => $company->city->value,
                    'address' => $company->address->value,
                    'nip' => $company->nip->value,
                    'postcode' => $company->postCode->value,
                ]
            );
        } catch (UniqueConstraintViolationException) {
            throw new NipAlreadyExistsException(
                sprintf(
                    'nip %s already exists',
                    $company->nip->value
                )
            );
        }
    }

    /**
     * @throws Exception
     */
    public function delete(CompanyId $companyId): void
    {
        $this->connection->executeStatement(
            'DELETE FROM companies WHERE id = :id',
            ['id' => $companyId->value]
        );
    }

    /**
     * @throws Exception
     */
    public function findById(CompanyId $companyId): ?CompanyView
    {
        $query = $this->connection->executeQuery(
            'SELECT id, name, city, address, nip, postcode FROM companies WHERE id = :id',
            ['id' => $companyId->value]
        );

        $result = $query->fetchAssociative();
        return !$result ? null : new CompanyView(
            new CompanyId($result['id']),
            new CompanyName($result['name']),
            new City($result['city']),
            new Address($result['address']),
            new Nip($result['nip']),
            new Postcode($result['postcode'])
        );
    }
}