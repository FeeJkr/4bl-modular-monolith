<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\User\Contract;

use App\Modules\Finances\Application\User\GetUserIdByToken\GetUserIdByTokenQuery;

interface UserContract
{
    public function getUserIdByToken(GetUserIdByTokenQuery $query): int;
}
