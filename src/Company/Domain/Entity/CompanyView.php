<?php

declare(strict_types=1);

namespace App\Company\Domain\Entity;

use App\Company\Domain\ValueObject\Address;
use App\Company\Domain\ValueObject\City;
use App\Company\Domain\ValueObject\CompanyName;
use App\Company\Domain\ValueObject\Nip;
use App\Company\Domain\ValueObject\PostCode;
use JsonSerializable;

readonly class CompanyView implements JsonSerializable
{
    public function __construct(
        public CompanyName $companyName,
        public City $city,
        public Address $address,
        public Nip $nip,
        public PostCode $postCode) {
    }

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->companyName->value,
            'nip' => $this->nip->value,
            'address' => $this->address->value,
            'city' => $this->city->value,
            'postcode' => $this->postCode->value
        ];
    }
}