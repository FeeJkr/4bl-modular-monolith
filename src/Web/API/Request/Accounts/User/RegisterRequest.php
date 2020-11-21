<?php
declare(strict_types=1);

namespace App\Web\API\Request\Accounts\User;

use App\Modules\Accounts\Application\User\Register\RegisterUserCommand;
use App\Web\API\Request\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class RegisterRequest extends Request
{
    private string $email;
    private string $username;
    private string $password;

    public function __construct(string $email, string $username, string $password)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $email = $request->get('email');
        $username = $request->get('username');
        $password = $request->get('password');

        Assert::lazy()
            ->that($email, 'email')->notEmpty()->email()
            ->that($username, 'username')->notEmpty()
            ->that($password, 'password')->notEmpty()->minLength(6)
            ->verifyNow();

        return new self(
            $email,
            $username,
            $password
        );
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
