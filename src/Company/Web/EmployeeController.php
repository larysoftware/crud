<?php

declare(strict_types=1);

namespace App\Company\Web;

use App\Company\Application\Command\DeleteEmployeeCommand;
use App\Company\Application\Command\UpdateEmployeeCommand;
use App\Company\Application\Dto\CreateEmployeeRequest;
use App\Company\Application\Dto\EmployeeCompanyRequestQuery;
use App\Company\Application\Query\GetAllEmployeeQuery;
use App\Company\Application\Query\GetEmployeeQuery;
use App\Company\Application\Service\CreateEmployeeHandler;
use App\Company\Domain\ValueObject\CompanyId;
use App\Company\Domain\ValueObject\EmployeeId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Exception;

class EmployeeController extends ApiAbstractController
{
    public function collect(GetAllEmployeeQuery $query, int $companyId): JsonResponse
    {
        try {
            $companyIdValue = new CompanyId($companyId);
            return new JsonResponse($query->query($companyIdValue)->getAll());
        } catch (Exception $exception) {
            return $this->handleException($exception, $companyIdValue ?? null);
        }
    }

    public function create(CreateEmployeeHandler $handler, CreateEmployeeRequest $request): JsonResponse
    {
        try {
            return new JsonResponse($handler->handle($request), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->handleException($exception, $request);
        }
    }

    public function get(GetEmployeeQuery $query, int $companyId, int $employeeId): JsonResponse
    {
        try {
            $request = new EmployeeCompanyRequestQuery(new CompanyId($companyId), new EmployeeId($employeeId));
            return new JsonResponse($query->query($request), Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->handleException($exception, $request ?? null);
        }
    }

    public function update(MessageBusInterface $messageBus, UpdateEmployeeCommand $command): JsonResponse
    {
        try {
            $messageBus->dispatch($command);
            return new JsonResponse($command, Response::HTTP_NO_CONTENT);
        } catch (HandlerFailedException $exception) {
            return $this->handleException($exception->getPrevious() ?? $exception, $command);
        }
    }

    public function delete(MessageBusInterface $messageBus, int $companyId, int $employeeId): JsonResponse
    {
        $command = new DeleteEmployeeCommand($companyId, $employeeId);
        try {
            $messageBus->dispatch($command);
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (HandlerFailedException $exception) {
            return $this->handleException($exception->getPrevious() ?? $exception, $command);
        }
    }
}