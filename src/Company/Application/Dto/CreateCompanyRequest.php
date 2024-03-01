<?php

declare(strict_types=1);

namespace App\Company\Application\Dto;

use JsonSerializable;

readonly class CreateCompanyRequest implements JsonSerializable
{
    public function __construct(
        public string $name,
        public string $nip,
        public string $address,
        public string $city,
        public string $postCode) {
    }

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'nip' => $this->nip,
            'address' => $this->address,
            'city' => $this->city,
            'post_code' => $this->postCode
        ];
    }
}