<?php

declare(strict_types=1);

namespace App\Company\Domain\Exception;

use InvalidArgumentException;

class PhoneNumberAlreadyExistsException extends InvalidArgumentException
{
    protected $message = 'phone_number already exists';
}