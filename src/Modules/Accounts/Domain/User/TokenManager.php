<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use App\Modules\Accounts\Domain\User\Token;

interface TokenManager
{
    public function generate(): Token;
    public function isValid(Token $token): bool;
}
