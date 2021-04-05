<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Company\GetOneById;

final class GetOneCompanyByIdQuery
{
    public function __construct(private int $companyId){}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }
}
