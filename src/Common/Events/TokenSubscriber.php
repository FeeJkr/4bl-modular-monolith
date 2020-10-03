<?php
declare(strict_types=1);

namespace App\Common\Events;

use App\Modules\Accounts\Infrastructure\UI\Http\Api\GenerateJWTTokenAction;
use Firebase\JWT\JWT;
use stdClass;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ErrorController;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class TokenSubscriber implements EventSubscriberInterface
{
    private string $jwtSecretKey;

    public function __construct(string $jwtSecretKey)
    {
        $this->jwtSecretKey = $jwtSecretKey;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        if ($event->getController() instanceof ErrorController) {
            return;
        }

        $jwtToken = $event->getRequest()->headers->get('X-Authorization');

        if ($event->getController() instanceof GenerateJWTTokenAction) {
            return;
        }

        if ($jwtToken !== null) {
            try {
                /** @var stdClass $data */
                $data = JWT::decode($jwtToken, $this->jwtSecretKey, ['HS256']);

                $event->getRequest()->request->set('user_id', $data->user_id);

                return;
            } catch (\UnexpectedValueException $exception) {
                $this->forbiddenResponse($event);
            }
        }

        $this->forbiddenResponse($event);
    }

    private function forbiddenResponse(ControllerEvent $event): void
    {
        $event->setController(static function (): Response {
            return new JsonResponse(['error' => 'Authentication error.'], Response::HTTP_FORBIDDEN);
        });
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
