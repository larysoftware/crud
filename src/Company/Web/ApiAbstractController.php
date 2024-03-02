<?php

declare(strict_types=1);

namespace App\Company\Web;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Company\Domain\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use InvalidArgumentException;
use JsonSerializable;
use Throwable;

use function json_encode;

abstract class ApiAbstractController extends AbstractController
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    protected function handleException(Throwable $throwable, ?JsonSerializable $request): JsonResponse
    {
        $this->logger->log(
            $this->getLogLevel($throwable),
            $throwable->getMessage(),
            $request !== null ? [
                'request' => json_encode($request)
            ] : []
        );

        return new JsonResponse(['error' => $throwable->getMessage()], $this->getHttpCodeByThrowable($throwable));
    }

    private function getLogLevel(Throwable $throwable): string
    {
        $logLevel = 'error';
        if ($throwable instanceof InvalidArgumentException || $throwable instanceof NotFoundException) {
            $logLevel = 'warning';
        }
        return $logLevel;
    }

    private function getHttpCodeByThrowable(Throwable $throwable): int
    {
        if ($throwable instanceof NotFoundException) {
            return Response::HTTP_NOT_FOUND;
        }
        if ($throwable instanceof InvalidArgumentException) {
            return Response::HTTP_BAD_REQUEST;
        }
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}