<?php
declare(strict_types=1);

namespace App\ReadModel\Category;

use App\SharedKernel\User\UserId;
use Doctrine\Common\Collections\Collection;

interface CategoryReadModelRepository
{
    public function fetchAll(UserId $userId): Collection;
}
