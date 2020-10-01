<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category;

use App\Modules\Finances\Domain\Category\CategoryId;
use App\SharedKernel\User\UserId;
use Doctrine\Common\Collections\Collection;

interface CategoryReadModelRepository
{
    public function fetchAll(UserId $userId): Collection;
    public function fetchOneById(UserId $userId, CategoryId $categoryId): ?CategoryDTO;
}
