<?php
declare(strict_types=1);

namespace App\Web\API\Middleware;

use App\Modules\Accounts\Application\User\LogicException as AccountsModuleLogicException;
use App\Modules\Accounts\Application\User\NotFoundException as AccountsModuleNotFoundException;
use App\Modules\Accounts\Application\User\ValidationException as AccountsModuleValidationException;
use App\Web\API\ValidationErrorResponse;
use Assert\LazyAssertionException;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

final class ErrorHandlerMiddleware implements EventSubscriberInterface
{
    /**
     * @throws Throwable
     */
    public function onKernelException(ExceptionEvent $event): void
    {
    	if (str_contains($event->getRequest()->getPathInfo(), '/api/')) {
			$exception = $event->getThrowable();

			// Modules exceptions handler
			if ($exception instanceof HandlerFailedException) {
				$exception = $exception->getPrevious();

				$statusCode = match ($exception::class) {
					AccountsModuleValidationException::class => Response::HTTP_BAD_REQUEST,
					AccountsModuleLogicException::class => Response::HTTP_CONFLICT,
					AccountsModuleNotFoundException::class => Response::HTTP_NOT_FOUND,
					default => throw $exception,
				};

				$event->setResponse(
					new JsonResponse(
						['errors' => $exception->getMessage()],
						$statusCode
					)
				);
			}

			// request validation exceptions handler
			if ($exception instanceof LazyAssertionException) {
				$event->setResponse(
					new JsonResponse(
						['errors' => ValidationErrorResponse::getResponse(...$exception->getErrorExceptions())],
						Response::HTTP_BAD_REQUEST
					)
				);
			}
		}
    }

    #[ArrayShape([KernelEvents::EXCEPTION => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
