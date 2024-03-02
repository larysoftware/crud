<?php

declare(strict_types=1);

namespace App\Company\Application\Command;

use JsonSerializable;

readonly class UpdateCompanyCommand implements JsonSerializable
{
    public function __construct(
        public int $id,
        public string $name,
        public string $nip,
        public string $address,
        public string $city,
        public string $postCode
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'company_id' => $this->id,
            'name' => $this->name,
            'nip' => $this->nip,
            'address' => $this->address,
            'city' => $this->city,
            'post_code' => $this->postCode
        ];
    }
}