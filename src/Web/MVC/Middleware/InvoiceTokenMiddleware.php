<?php
declare(strict_types=1);

namespace App\Web\MVC\Middleware;

use App\Web\MVC\Controller\Finances\InvoiceController;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class InvoiceTokenMiddleware implements EventSubscriberInterface
{
    public function __construct(private string $invoiceToken, private UrlGeneratorInterface $urlGenerator){}

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (is_array($controller) && $controller[0] instanceof InvoiceController) {
            $token = $event->getRequest()->get('token');

            if ($token === $this->invoiceToken) {
                return;
            }

            $event->setController(function (): Response {
                return new RedirectResponse($this->urlGenerator->generate('dashboard'));
            });
        }
    }

    #[ArrayShape([KernelEvents::CONTROLLER => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
