<?php

declare(strict_types=1);

namespace App\Company\Application\Dto;

use App\Company\Domain\ValueObject\CompanyId;
use JsonSerializable;

readonly class GetCompanyByIdRequest implements JsonSerializable
{
    public function __construct(public CompanyId $companyId)
    {
    }

    /**
     * @return array<string, int>
     */
    public function jsonSerialize(): array
    {
        return [
            'company_id' => $this->companyId->value
        ];
    }
}