<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User;

use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\TokenManager;
use DateTime;
use Firebase\JWT\JWT;
use Throwable;

final class JWTTokenManager implements TokenManager
{
    private string $jwtSecretKey;
    private array $algorithms;

    public function __construct(string $jwtSecretKey, array $algorithms = ['HS256'])
    {
        $this->jwtSecretKey = $jwtSecretKey;
        $this->algorithms = $algorithms;
    }

    public function generate(): Token
    {
        $payload = [
            'exp' => (new DateTime())->modify('+ 30 days')->getTimestamp()
        ];

        return new Token(JWT::encode($payload, $this->jwtSecretKey, $this->algorithms[0]));
    }

    public function isValid(Token $token): bool
    {
        try {
            JWT::decode($token->toString(), $this->jwtSecretKey, $this->algorithms);

            return true;
        } catch (Throwable) {
            return false;
        }
    }
}
