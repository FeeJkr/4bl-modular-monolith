<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\User;

interface UserService
{
    public function getUserIdByToken(string $token): int;
}
