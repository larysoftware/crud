<?php

declare(strict_types=1);

namespace App\Company\Infrastructure\ValueResolver;

use App\Company\Application\Command\UpdateEmployeeCommand;
use App\Company\Application\Factory\UpdateEmployeeCommandFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use JsonException;
use InvalidArgumentException;

readonly class UpdateEmployeeCommandResolver implements ValueResolverInterface
{
    public function __construct(private UpdateEmployeeCommandFactory $factory)
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== UpdateEmployeeCommand::class) {
            return [];
        }
        try {
            yield $this->factory->create(
                (int)$request->get('companyId'),
                (int)$request->get('employeeId'),
                json_decode(
                    $request->getContent(),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                )
            );
        } catch (JsonException) {
            throw new InvalidArgumentException('invalid request body');
        }
    }
}