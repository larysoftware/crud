<?php

declare(strict_types=1);

namespace App\Company\Domain\Exception;

use InvalidArgumentException;

class EmailAlreadyExistsException extends InvalidArgumentException
{
    protected $message = 'email already exists';
}