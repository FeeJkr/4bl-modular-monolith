<?php
declare(strict_types=1);

namespace App\Web\API\Middleware;

use App\Web\API\ValidationErrorResponse;
use Assert\LazyAssertionException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ErrorHandlerMiddleware implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof LazyAssertionException) {
            $event->setResponse(
                new JsonResponse(
                    ValidationErrorResponse::getResponse(...$exception->getErrorExceptions()),
                    Response::HTTP_BAD_REQUEST
                )
            );
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
