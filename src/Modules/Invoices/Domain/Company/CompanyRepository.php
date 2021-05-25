<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use App\Modules\Invoices\Domain\User\UserId;

interface CompanyRepository
{
    /**
     * @throws CompanyNotFoundException
     */
    public function fetchById(CompanyId $id, UserId $userId): Company;
    public function fetchAll(UserId $userId): array;
    public function store(Company $company): void;
    public function delete(CompanyId $companyId, UserId $userId): void;
}
