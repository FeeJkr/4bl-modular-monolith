<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\User;

use App\Modules\Finances\Domain\User\Token;
use App\Modules\Finances\Domain\User\UserId;

interface UserService
{
    public function getUserIdByToken(Token $token): UserId;
}
