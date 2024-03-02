<?php

declare(strict_types=1);

namespace App\Company\Web;

use App\Company\Application\Dto\CreateEmployeeRequest;
use App\Company\Application\Service\CreateEmployeeHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class EmployeeController extends ApiAbstractController
{
    public function create(CreateEmployeeHandler $handler, CreateEmployeeRequest $request): JsonResponse
    {
        try {
            return new JsonResponse($handler->handle($request), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->handleException($exception, $request);
        }
    }
}