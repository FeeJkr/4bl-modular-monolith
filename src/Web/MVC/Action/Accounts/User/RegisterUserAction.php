<?php
declare(strict_types=1);

namespace App\Web\MVC\Action\Accounts\User;

use App\Modules\Accounts\Application\User\Register\RegisterUserCommand;
use Assert\Assert;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class RegisterUserAction extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): Response
    {
        if ($request->getMethod() === 'GET') {
            return $this->render('accounts/user/register.html.twig');
        }

        $email = $request->get('email');
        $username = $request->get('username');
        $password = $request->get('password');
        $repeatPassword = $request->get('repeat_password');

        try {
            Assert::lazy()
                ->that($email, 'email')->email()
                ->that($username, 'username')->notEmpty()
                ->that($password, 'password')->notEmpty()
                ->that($repeatPassword, 'repeat_password')->notEmpty()
                ->that($password, 'repeat_password_is_true')->same($repeatPassword)
                ->verifyNow();
        } catch (LazyAssertionException $exception) {
            return $this->redirectToRoute('accounts.user.register');
        }

        $command = new RegisterUserCommand($email, $username, $password);

        $this->bus->dispatch($command);

        return $this->redirectToRoute('accounts.user.sign-in');
    }
}
