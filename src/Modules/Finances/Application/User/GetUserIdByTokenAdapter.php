<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\User;

interface GetUserIdByTokenAdapter
{
    public function getUserIdByToken(string $token): int;
}
