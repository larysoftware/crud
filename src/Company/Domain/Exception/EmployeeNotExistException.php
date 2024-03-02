<?php

declare(strict_types=1);

namespace App\Company\Domain\Exception;

use Exception;

class EmployeeNotExistException extends Exception implements NotFoundException
{
    protected $message = 'employee not exist';
}