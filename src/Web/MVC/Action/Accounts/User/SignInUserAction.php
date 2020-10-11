<?php
declare(strict_types=1);

namespace App\Web\MVC\Action\Accounts\User;

use App\Modules\Accounts\Application\User\FetchToken\FetchTokenQuery;
use App\Modules\Accounts\Application\User\FetchToken\TokenDTO;
use App\Modules\Accounts\Application\User\SignIn\SignInUserCommand;
use Assert\Assert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class SignInUserAction extends AbstractController
{
    private SessionInterface $session;
    private MessageBusInterface $bus;

    public function __construct(SessionInterface $session, MessageBusInterface $bus)
    {
        $this->session = $session;
        $this->bus = $bus;
    }

    public function __invoke(Request $request): Response
    {
        if ($request->getMethod() === 'GET') {
            return $this->render('accounts/user/sign-in.html.twig');
        }

        $email = $request->get('email');
        $password = $request->get('password');

        Assert::lazy()
            ->that($email, 'email')->email()
            ->that($password, 'password')->notEmpty()
            ->verifyNow();

        $this->bus->dispatch(new SignInUserCommand($email, $password));

        /** @var TokenDTO $token */
        $token = $this->bus
            ->dispatch(new FetchTokenQuery($email))
            ->last(HandledStamp::class)
            ->getResult();


        $this->session->set('user.token', $token->getToken());

        return $this->redirectToRoute('dashboard');
    }
}
