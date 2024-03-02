<?php

declare(strict_types=1);

namespace App\Company\Application\Factory;

use App\Company\Application\Dto\CreateEmployeeRequest;
use InvalidArgumentException;

use function sprintf;

class CreateEmployeeRequestFactory extends AbstractRequestFactory
{
    private const FIRST_NAME = 'first_name';
    private const LAST_NAME = 'last_name';
    private const EMAIL = 'email';
    private const PHONE_NUMBER = 'phone_number';

    private const REQUIRED_TEXT_DATA = [
      self::FIRST_NAME,
      self::LAST_NAME,
      self::EMAIL
    ];

    /**
     * @throws InvalidArgumentException
     */
    public function create(int $companyId, array $data): CreateEmployeeRequest
    {
        $this->validRequiredTextData(self::REQUIRED_TEXT_DATA, $data);
        if (isset($data[self::PHONE_NUMBER]) && !is_string($data[self::PHONE_NUMBER])) {
            throw new InvalidArgumentException(
                sprintf(
                    'field %s must be a string',
                    self::PHONE_NUMBER
                )
            );
        }

        return new CreateEmployeeRequest(
            $companyId,
            $data[self::FIRST_NAME],
            $data[self::LAST_NAME],
            $data[self::EMAIL],
            $data[self::PHONE_NUMBER] ?? null
        );
    }
}