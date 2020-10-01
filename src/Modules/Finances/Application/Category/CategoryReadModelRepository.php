<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category;

use App\Common\User\UserId;
use App\Modules\Finances\Domain\Category\CategoryId;
use Doctrine\Common\Collections\Collection;

interface CategoryReadModelRepository
{
    public function fetchAll(UserId $userId): Collection;
    public function fetchOneById(UserId $userId, CategoryId $categoryId): ?CategoryDTO;
}
