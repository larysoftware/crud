<?php

declare(strict_types=1);

namespace App\Company\Infrastructure\ValueResolver;

use App\Company\Application\Command\UpdateCompanyCommand;
use App\Company\Application\Factory\UpdateCompanyCommandFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use JsonException;
use InvalidArgumentException;

readonly class UpdateCompanyCommandResolver implements ValueResolverInterface
{
    public function __construct(private UpdateCompanyCommandFactory $factory)
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== UpdateCompanyCommand::class) {
            return [];
        }
        try {
            yield $this->factory->create(
                (int)$request->get('companyId'),
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