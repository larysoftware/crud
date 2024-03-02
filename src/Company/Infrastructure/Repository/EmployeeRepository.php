<?php

declare(strict_types=1);

namespace App\Company\Infrastructure\Repository;

use App\Company\Domain\Entity\Employee;
use App\Company\Domain\Entity\EmployeeView;
use App\Company\Domain\Exception\CompanyNotExistException;
use App\Company\Domain\Exception\EmailAlreadyExistsException;
use App\Company\Domain\Exception\PhoneNumberAlreadyExistsException;
use App\Company\Domain\Repository\EmployeeRepositoryInterface;
use App\Company\Domain\ValueObject\EmployeeId;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception;

use function sprintf;
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
    public function create(Employee $employee): EmployeeId
    {
        try {
            $this->connection->executeStatement('
            INSERT INTO `employees` (`first_name`, `last_name`, `email`, `phone_number`, `company_id`) 
            VALUES (:first_name, :last_name, :email, :phone_number, :company_id)', [
                'company_id' => $employee->companyId->value,
                'first_name' => $employee->firstName->value,
                'last_name' => $employee->lastName->value,
                'email' => $employee->email->value,
                'phone_number' => $employee->phoneNumber?->value
            ]);
            return new EmployeeId((int)$this->connection->lastInsertId());
        } catch (ForeignKeyConstraintViolationException) {
            throw new CompanyNotExistException(
                sprintf(
                    'company_id %d not exist',
                    $employee->companyId->value
                )
            );
        } catch (UniqueConstraintViolationException $exception) {
            throw strpos($exception->getMessage(), 'email') !== false
                ? new EmailAlreadyExistsException
                : new PhoneNumberAlreadyExistsException;
        }
    }

    public function update(Employee $employee): void
    {
        // TODO: Implement update() method.
    }

    public function findById(EmployeeId $employeeId): ?EmployeeView
    {
        return null;
    }

    public function delete(EmployeeId $employeeId): void
    {
        // TODO: Implement delete() method.
    }
}