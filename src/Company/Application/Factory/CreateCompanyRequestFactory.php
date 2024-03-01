<?php

declare(strict_types=1);

namespace App\Company\Application\Factory;

use App\Company\Application\Dto\CreateCompanyRequest;
use InvalidArgumentException;

use function sprintf;

class CreateCompanyRequestFactory
{
    private const NAME = 'name';
    private const NIP = 'nip';
    private const ADDRESS = 'address';
    private const CITY = 'city';
    private const POSTCODE = 'postcode';

    private const ALL_FIELDS = [
        self::NAME,
        self::NIP,
        self::ADDRESS,
        self::CITY,
        self::POSTCODE
    ];

    public function create(array $data): CreateCompanyRequest
    {
        $this->validData($data);
        return new CreateCompanyRequest(
          $data[self::NAME],
          $data[self::NIP],
          $data[self::ADDRESS],
          $data[self::CITY],
          $data[self::POSTCODE]
        );
    }

    private function validData(array $data): void
    {
        foreach (self::ALL_FIELDS as $field) {
            if (!isset($data[$field]) || !is_string($data[$field])) {
                throw new InvalidArgumentException(
                    sprintf(
                        'field %s is required and must be a string',
                        $field
                    )
                );
            }
        }
    }
}