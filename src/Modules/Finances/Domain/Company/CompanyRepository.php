<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Company;

use App\Modules\Finances\Domain\User\UserId;

interface CompanyRepository
{
    public function fetchById(CompanyId $id, UserId $userId): Company;
    public function fetchAll(): array;
}
