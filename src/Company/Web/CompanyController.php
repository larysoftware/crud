<?php

declare(strict_types=1);

namespace App\Company\Web;

use App\Company\Application\Command\DeleteCompanyCommand;
use App\Company\Application\Command\UpdateCompanyCommand;
use App\Company\Application\Dto\CompanyRequestQuery;
use App\Company\Application\Query\GetCompanyQuery;
use App\Company\Domain\ValueObject\CompanyId;
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

    public function get(GetCompanyQuery $query, int $companyId): JsonResponse
    {
        try {
            $request = new CompanyRequestQuery(new CompanyId($companyId));
            return new JsonResponse($query->query($request), Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->handleException($exception, $request ?? null);
        }
    }

    public function update(MessageBusInterface $messageBus, UpdateCompanyCommand $command): JsonResponse
    {
        try {
            $messageBus->dispatch($command);
            return new JsonResponse($command, Response::HTTP_NO_CONTENT);
        } catch (HandlerFailedException $exception) {
            return $this->handleException($exception->getPrevious() ?? $exception, $command);
        }
    }

    public function delete(MessageBusInterface $messageBus, int $companyId): JsonResponse
    {
        $command = new DeleteCompanyCommand($companyId);
        try {
            $messageBus->dispatch($command);
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (HandlerFailedException $exception) {
            return $this->handleException($exception->getPrevious() ?? $exception, $command);
        }
    }
}