<?php

declare(strict_types=1);

namespace App\Company\Application\Factory;

use InvalidArgumentException;

use function sprintf;

abstract class AbstractRequestFactory
{
    /**
     * @throws InvalidArgumentException
     */
    protected function validRequiredTextData(array $fields, array $data): void
    {
        foreach ($fields as $field) {
            if (!is_string($data[$field] ?? null)) {
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