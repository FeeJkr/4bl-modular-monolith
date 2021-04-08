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
    public function register(): Response
    {
        return $this->render('accounts/user/register.html.twig');
    }

    public function signIn(): Response
    {
        return $this->render('accounts/user/sign-in.html.twig');
    }
}
