<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\User\FetchUserIdByToken;

use App\Modules\Finances\Domain\User\Token;

final class FetchUserIdByTokenQuery
{
    private Token $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    public function getToken(): Token
    {
        return $this->token;
    }
}
