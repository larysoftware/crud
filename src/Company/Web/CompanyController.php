<?php

declare(strict_types=1);

namespace App\Company\Web;

use App\Company\Application\Dto\CreateCompanyRequest;
use App\Company\Application\Service\CreateCompanyHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use InvalidArgumentException;
use Exception;

use function json_encode;

class CompanyController extends AbstractController
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function create(CreateCompanyHandler $companyHandler, CreateCompanyRequest $request): JsonResponse
    {
        try {
            return new JsonResponse($companyHandler->handle($request), Response::HTTP_CREATED);
        } catch (InvalidArgumentException $invalidArgumentException) {
            $this->logger->warning(
                $invalidArgumentException->getMessage(),
                [
                    'request' => json_encode($request)
                ]
            );
            return new JsonResponse(
                [
                    'error' => $invalidArgumentException->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        } catch (Exception $exception) {
            $this->logger->error(
                $exception->getMessage(),
                [
                    'request' => json_encode($request)
                ]
            );
            return new JsonResponse(
                [
                    'error' => $exception->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function delete(): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    public function update(): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_OK);
    }

    public function get(): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_OK);
    }
}