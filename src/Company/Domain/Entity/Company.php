<?php

declare(strict_types=1);

namespace App\Company\Domain\Entity;

use App\Company\Domain\ValueObject\Address;
use App\Company\Domain\ValueObject\City;
use App\Company\Domain\ValueObject\CompanyId;
use App\Company\Domain\ValueObject\CompanyName;
use App\Company\Domain\ValueObject\PostCode;
use App\Company\Domain\ValueObject\Nip;

class Company
{
    public function __construct(
       public ?CompanyId $companyId,
       public CompanyName $companyName,
       public City $city,
       public Address $address,
       public Nip $nip,
       public PostCode $postCode) {
    }
}