<?php

declare(strict_types=1);

namespace App\Company\Domain\Entity;

use App\Company\Domain\ValueObject\Address;
use App\Company\Domain\ValueObject\City;
use App\Company\Domain\ValueObject\CompanyId;
use App\Company\Domain\ValueObject\CompanyName;
use App\Company\Domain\ValueObject\Nip;
use App\Company\Domain\ValueObject\PostCode;
use JsonSerializable;

class CompanyView implements JsonSerializable
{
    public function __construct(
        public CompanyId $companyId,
        public CompanyName $companyName,
        public City $city,
        public Address $address,
        public Nip $nip,
        public PostCode $postCode) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->companyId->value,
            'name' => $this->companyName->value,
            'nip' => $this->nip->value,
            'address' => $this->address->value,
            'city' => $this->city->value,
            'postcode' => $this->postCode->value
        ];
    }
}