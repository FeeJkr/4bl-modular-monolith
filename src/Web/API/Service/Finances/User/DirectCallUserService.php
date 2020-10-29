<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\User;

use App\Modules\Finances\Application\User\Contract\UserContract;
use App\Modules\Finances\Application\User\GetUserIdByToken\GetUserIdByTokenQuery;

final class DirectCallUserService implements UserService
{
    private UserContract $userContract;

    public function __construct(UserContract $userContract)
    {
        $this->userContract = $userContract;
    }

    public function getUserIdByToken(string $token): int
    {
        return $this->userContract->getUserIdByToken(
            new GetUserIdByTokenQuery($token)
        );
    }
}
