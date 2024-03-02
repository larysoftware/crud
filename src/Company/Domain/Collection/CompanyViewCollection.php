<?php

declare(strict_types=1);

namespace App\Company\Domain\Collection;

use App\Company\Domain\Entity\CompanyView;
use Countable;

use function count;

class CompanyViewCollection implements Countable
{
    /**
     * @var CompanyView[]
     */
    private array $collection = [];

    public function add(CompanyView $companyView): void
    {
        $this->collection[] = $companyView;
    }

    public function count(): int
    {
        return count($this->collection);
    }

    public function getAll(): array
    {
        return $this->collection;
    }
}