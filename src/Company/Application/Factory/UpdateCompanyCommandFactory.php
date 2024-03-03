<?php

declare(strict_types=1);

namespace App\Company\Application\Factory;

use App\Company\Application\Command\UpdateCompanyCommand;
use InvalidArgumentException;

class UpdateCompanyCommandFactory extends AbstractRequestFactory
{
    private const NAME = 'name';
    private const NIP = 'nip';
    private const ADDRESS = 'address';
    private const CITY = 'city';
    private const POSTCODE = 'postcode';

    private const REQUIRED_TEXT_DATA = [
        self::NAME,
        self::NIP,
        self::ADDRESS,
        self::CITY,
        self::POSTCODE
    ];

    /**
     * @throws InvalidArgumentException
     */
    public function create(int $id, array $data): UpdateCompanyCommand
    {
        $this->validRequiredTextData(self::REQUIRED_TEXT_DATA, $data);
        return new UpdateCompanyCommand(
            $id,
            $data[self::NAME],
            $data[self::NIP],
            $data[self::ADDRESS],
            $data[self::CITY],
            $data[self::POSTCODE]
        );
    }
}