<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller\Accounts\Auth;

use App\Modules\Accounts\Application\User\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\User\GetToken\TokenDTO;
use App\Modules\Accounts\Application\User\Register\RegisterUserCommand;
use App\Modules\Accounts\Application\User\SignIn\SignInUserCommand;
use App\Web\MVC\Controller\AbstractController;
use Assert\Assert;
use Assert\LazyAssertionException;
use DateTime;
use PHPHtmlParser\Dom;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class AuthController extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function showRegisterPage(): Response
    {
        return $this->render('accounts/user/register.html.twig');
    }

    public function register(Request $request): Response
    {
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

    public function showSignInPage(): Response
    {
        return $this->render('accounts/user/sign-in.html.twig');
    }

    public function signIn(Request $request): Response
    {
        $email = $request->get('email');
        $password = $request->get('password');

        Assert::lazy()
            ->that($email, 'email')->email()
            ->that($password, 'password')->notEmpty()
            ->verifyNow();

        $this->bus->dispatch(new SignInUserCommand($email, $password));

        /** @var TokenDTO $token */
        $token = $this->bus
            ->dispatch(new GetTokenQuery($email))
            ->last(HandledStamp::class)
            ->getResult();

        $request->getSession()->set('user.token', $token->getToken());

        return $this->redirectToRoute('dashboard');
    }
}
