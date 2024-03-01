<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\EventListener;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{

    public function __construct(public LoggerInterface $logger)
    {
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof InvalidArgumentException) {
            $this->logger->warning($exception->getMessage(), [
                'request' => $event->getRequest()->getContent()
            ]);
            $event->setResponse(
                new JsonResponse(
                    [
                        'error' => $exception->getMessage()
                    ],
                    Response::HTTP_BAD_REQUEST
                )
            );
        }
    }
}