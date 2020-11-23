<?php
declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\SignIn;

use App\Modules\Accounts\Application\User\GetToken\TokenDTO;

final class SignInUserResponse
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public static function createFromTokenDTO(TokenDTO $tokenDTO): self
    {
        return new self(
            $tokenDTO->getToken()
        );
    }

    public function getResponse(): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
