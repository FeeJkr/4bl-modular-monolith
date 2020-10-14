<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\User;

interface UserRepository
{
    public function fetchIdByToken(Token $token): UserId;
}
