<?php

declare(strict_types=1);

namespace App\Company\Web;

use App\Company\Application\Command\UpdateCompanyCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Company\Application\Dto\CreateCompanyRequest;
use App\Company\Application\Service\CreateCompanyHandler;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Exception;

class CompanyController extends ApiAbstractController
{
    public function create(CreateCompanyHandler $companyHandler, CreateCompanyRequest $request): JsonResponse
    {
        try {
            return new JsonResponse($companyHandler->handle($request), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->handleException($exception, $request);
        }
    }

    public function delete(): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    public function update(MessageBusInterface $messageBus, UpdateCompanyCommand $command): JsonResponse
    {
        try {
            $messageBus->dispatch($command);
            return new JsonResponse($command, Response::HTTP_OK);
        } catch (HandlerFailedException $invalidArgumentException) {
            return $this->handleException($invalidArgumentException->getPrevious(), $command);
        }
    }

    public function get(): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_OK);
    }
}