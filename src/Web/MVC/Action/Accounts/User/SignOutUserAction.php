<?php
declare(strict_types=1);

namespace App\Web\MVC\Action\Accounts\User;

use App\Modules\Accounts\Application\User\SignOut\SignOutUserCommand;
use App\Modules\Accounts\Domain\User\Token;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class SignOutUserAction extends AbstractController
{
    private MessageBusInterface $bus;
    private SessionInterface $session;

    public function __construct(MessageBusInterface $bus, SessionInterface $session)
    {
        $this->bus = $bus;
        $this->session = $session;
    }

    public function __invoke(): Response
    {
        $command = new SignOutUserCommand(
            new Token($this->session->get('user.token'))
        );

        $this->bus->dispatch($command);

        $this->session->remove('user.token');

        return $this->redirectToRoute('sign-in');
    }
}
