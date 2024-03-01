<?php

declare(strict_types=1);

namespace App\Company\Infrastructrue\ValueResolver;

use App\Company\Application\Dto\CreateCompanyRequest;
use App\Company\Application\Factory\CreateCompanyRequestFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use JsonException;
use InvalidArgumentException;

use function json_decode;

readonly class CreateCompanyRequestResolver implements ValueResolverInterface
{

    public function __construct(private CreateCompanyRequestFactory $factory)
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== CreateCompanyRequest::class) {
            return [];
        }

        try {
            yield $this->factory->create(
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