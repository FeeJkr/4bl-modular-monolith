<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Company\Delete;

class DeleteCompanyCommand
{
    public function __construct(private int $companyId){}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }
}