<?php

declare(strict_types=1);

namespace App\Company\Domain\Exception;

use Exception;

class CompanyNotExistException extends Exception implements NotFoundException
{
}