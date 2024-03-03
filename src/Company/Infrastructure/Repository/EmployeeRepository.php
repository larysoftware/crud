<?php

declare(strict_types=1);

namespace App\Company\Infrastructure\Repository;

use App\Company\Domain\Collection\EmployeeViewCollection;
use App\Company\Domain\Entity\Employee;
use App\Company\Domain\Entity\EmployeeView;
use App\Company\Domain\Exception\CompanyNotExistException;
use App\Company\Domain\Exception\EmailAlreadyExistsException;
use App\Company\Domain\Exception\PhoneNumberAlreadyExistsException;
use App\Company\Domain\Repository\EmployeeRepositoryInterface;
use App\Company\Domain\ValueObject\CompanyId;
use App\Company\Domain\ValueObject\Email;
use App\Company\Domain\ValueObject\EmployeeId;
use App\Company\Domain\ValueObject\FirstName;
use App\Company\Domain\ValueObject\LastName;
use App\Company\Domain\ValueObject\PhoneNumber;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception;

use function strpos;

readonly class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    /**
     * @throws CompanyNotExistException
     * @throws EmailAlreadyExistsException
     * @throws PhoneNumberAlreadyExistsException
     * @throws Exception
     */
    public function save(Employee $employee): EmployeeId
    {
        return $employee->employeeId ? $this->update($employee) : $this->create($employee);
    }

    /**
     * @throws Exception
     */
    public function findAllByCompanyId(CompanyId $companyId): EmployeeViewCollection
    {
        $collection = new EmployeeViewCollection();
        $query = $this->connection->executeQuery(
            'SELECT `id`,`first_name`, `last_name`, `email`, `phone_number` FROM employees WHERE company_id = :company_id',
            [
                'company_id' => $companyId->value
            ]
        );
        $results = $query->fetchAllAssociative();
        foreach ($results as $result) {
            $collection->add(
                new EmployeeView(
                    new EmployeeId($result['id']),
                    new FirstName($result['first_name']),
                    new LastName($result['last_name']),
                    new Email($result['email']),
                    $result['phone_number'] ? new PhoneNumber($result['phone_number']) : null
                )
            );
        }
        return $collection;
    }

    /**
     * @throws Exception
     */
    public function findByCompanyIdAndEmployeeId(CompanyId $companyId, EmployeeId $employeeId): ?EmployeeView
    {
        $query = $this->connection->executeQuery(
            'SELECT `id`,`first_name`, `last_name`, `email`, `phone_number` FROM employees WHERE id = :id AND company_id = :company_id',
            [
                'id' => $employeeId->value,
                'company_id' => $companyId->value
            ]
        );

        $result = $query->fetchAssociative();
        return $result ? new EmployeeView(
            new EmployeeId($result['id']),
            new FirstName($result['first_name']),
            new LastName($result['last_name']),
            new Email($result['email']),
            $result['phone_number'] ? new PhoneNumber($result['phone_number']) : null
        ) : null;
    }

    /**
     * @throws Exception
     */
    public function deleteByCompanyIdAndEmployeeId(CompanyId $companyId, EmployeeId $employeeId): void
    {
        $this->connection->executeStatement(
            'DELETE FROM employees WHERE id = :id AND company_id = :company_id',
            [
                'id' => $employeeId->value,
                'company_id' => $companyId->value
            ]
        );
    }

    /**
     * @throws CompanyNotExistException
     * @throws EmailAlreadyExistsException
     * @throws PhoneNumberAlreadyExistsException
     * @throws Exception
     */
    private function create(Employee $employee): EmployeeId
    {
        try {
            $this->connection->executeStatement('
            INSERT INTO employees (`first_name`, `last_name`, `email`, `phone_number`, `company_id`) 
            VALUES (:first_name, :last_name, :email, :phone_number, :company_id)', [
                'company_id' => $employee->companyId->value,
                'first_name' => $employee->firstName->value,
                'last_name' => $employee->lastName->value,
                'email' => $employee->email->value,
                'phone_number' => $employee->phoneNumber?->value
            ]);
            return new EmployeeId((int)$this->connection->lastInsertId());
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * @throws CompanyNotExistException
     * @throws EmailAlreadyExistsException
     * @throws PhoneNumberAlreadyExistsException
     * @throws Exception
     */
    private function update(Employee $employee): EmployeeId
    {
        try {
            $this->connection->executeStatement('
                UPDATE employees SET 
                first_name = :first_name, 
                last_name = :last_name,
                email = :email,
                phone_number = :phone_number
                WHERE id = :id AND company_id = :company_id
            ', [
                'first_name' => $employee->firstName->value,
                'last_name' => $employee->lastName->value,
                'email' => $employee->email->value,
                'phone_number' => $employee->phoneNumber?->value,
                'id' => $employee->employeeId->value,
                'company_id' => $employee->companyId->value
            ]);
            return $employee->employeeId;
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * @throws CompanyNotExistException
     * @throws EmailAlreadyExistsException
     * @throws PhoneNumberAlreadyExistsException
     * @throws Exception
     */
    private function handleException(Exception $exception): void
    {
        if ($exception instanceof ForeignKeyConstraintViolationException) {
            throw new CompanyNotExistException;
        }
        if ($exception instanceof UniqueConstraintViolationException) {
            throw strpos($exception->getMessage(), 'email') !== false
                ? new EmailAlreadyExistsException
                : new PhoneNumberAlreadyExistsException;
        }
        throw $exception;
    }
}