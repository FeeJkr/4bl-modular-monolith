<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\Register;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class RegisterUserRequest extends Request
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

    public static function fromRequest(ServerRequest $request): self
    {
    	$requestData = $request->toArray();

        $email = $requestData['email'];
        $username = $requestData['username'];
        $password = $requestData['password'];

        Assert::lazy()
            ->that($email, 'email')->notEmpty()->email()
            ->that($username, 'username')->notEmpty()
            ->that($password, 'password')->notEmpty()->minLength(8)->maxLength(255)
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
