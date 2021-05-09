<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\Logout;

use App\Common\Application\Command\CommandBus;
use App\Modules\Accounts\Application\User\SignOut\SignOutUserCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LogoutUserAction extends AbstractAction
{
    public function __construct(private CommandBus $bus, private SessionInterface $session){}

    public function __invoke(): Response
    {
        $token = $this->session->get('user.token');

        if ($token === null) {
            return $this->noContentResponse();
        }

        $this->bus->dispatch(new SignOutUserCommand($token));

        $this->session->clear();

        return $this->noContentResponse();
    }
}