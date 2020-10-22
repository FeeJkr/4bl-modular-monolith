<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller\Accounts;

use App\Modules\Accounts\Application\User\SignOut\SignOutUserCommand;
use App\Web\MVC\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class UserController extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function signOut(Request $request): Response
    {
        $command = new SignOutUserCommand(
            $request->getSession()->get('user.token')
        );

        $this->bus->dispatch($command);

        $request->getSession()->remove('user.token');

        return $this->redirectToRoute('accounts.user.sign-in');
    }
}
