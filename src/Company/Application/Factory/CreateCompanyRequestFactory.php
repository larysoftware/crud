<?php

declare(strict_types=1);

namespace App\Company\Application\Factory;

use App\Company\Application\Dto\CreateCompanyRequest;
use InvalidArgumentException;

class CreateCompanyRequestFactory extends AbstractRequestFactory
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

    /**
     * @throws InvalidArgumentException
     */
    public function create(array $data): CreateCompanyRequest
    {
        $this->validRequiredTextData(self::ALL_FIELDS, $data);
        return new CreateCompanyRequest(
          $data[self::NAME],
          $data[self::NIP],
          $data[self::ADDRESS],
          $data[self::CITY],
          $data[self::POSTCODE]
        );
    }
}