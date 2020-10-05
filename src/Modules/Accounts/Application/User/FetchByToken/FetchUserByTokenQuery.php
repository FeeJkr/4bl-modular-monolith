<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\FetchByToken;

use App\Modules\Accounts\Domain\User\Token;

final class FetchUserByTokenQuery
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
