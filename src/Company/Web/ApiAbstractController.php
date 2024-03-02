<?php

declare(strict_types=1);

namespace App\Company\Web;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use InvalidArgumentException;
use JsonSerializable;
use Exception;

abstract class ApiAbstractController extends AbstractController
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    protected function handleException(?Exception $exception, JsonSerializable $request)
    {
        if ($exception instanceof InvalidArgumentException) {
            $this->logger->warning(
                $exception->getMessage(),
                [
                    'request' => json_encode($request)
                ]
            );
            return new JsonResponse(
                [
                    'error' => $exception->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
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