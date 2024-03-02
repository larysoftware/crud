<?php

declare(strict_types=1);

namespace App\Company\Application\Factory;

use App\Company\Application\Command\UpdateCompanyCommand;
use InvalidArgumentException;

use function sprintf;
use function is_string;

class UpdateCompanyCommandFactory
{
    private const NAME = 'name';
    private const NIP = 'nip';
    private const ADDRESS = 'address';
    private const CITY = 'city';
    private const POSTCODE = 'postcode';

    private const REQUIRED_STRING_DATA = [
        self::NAME,
        self::NIP,
        self::ADDRESS,
        self::CITY,
        self::POSTCODE
    ];


    public function create(int $id, array $data): UpdateCompanyCommand
    {
        $this->validBodyData($data);
        return new UpdateCompanyCommand(
            $id,
            $data[self::NAME],
            $data[self::NIP],
            $data[self::ADDRESS],
            $data[self::CITY],
            $data[self::POSTCODE]
        );
    }

    private function validBodyData(array $data): void
    {
        foreach (self::REQUIRED_STRING_DATA as $field) {
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