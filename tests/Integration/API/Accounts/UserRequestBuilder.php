<?php
declare(strict_types=1);

namespace App\Tests\Integration\API\Accounts;

use JetBrains\PhpStorm\ArrayShape;

final class UserRequestBuilder
{
    public function __construct(
        private string $username = UserItemGenerator::USERNAME,
        private string $email = UserItemGenerator::EMAIL,
        private string $password = UserItemGenerator::PASSWORD
    ) {}

    #[ArrayShape(['username' => "string", 'email' => "string", 'password' => "string"])]
    public function buildRegister(): array
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
