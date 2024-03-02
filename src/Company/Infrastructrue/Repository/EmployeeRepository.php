<?php

declare(strict_types=1);

namespace App\Company\Infrastructrue\Repository;

use App\Company\Domain\Entity\Employee;
use App\Company\Domain\Entity\EmployeeView;
use App\Company\Domain\Repository\EmployeeRepositoryInterface;
use App\Company\Domain\ValueObject\EmployeeId;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception;

readonly class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function create(Employee $employee): EmployeeId
    {
        // TODO: Implement insert() method.
    }

    public function update(Employee $employee): void
    {
        // TODO: Implement update() method.
    }

    public function findById(EmployeeId $employeeId): EmployeeView
    {
        // TODO: Implement findById() method.
    }

    public function delete(EmployeeId $employeeId): void
    {
        // TODO: Implement delete() method.
    }
}