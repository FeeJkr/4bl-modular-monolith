<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Delete;

use App\Common\Application\Command\Command;

class DeleteCompanyCommand implements Command
{
    public function __construct(private string $companyId){}

    public function getCompanyId(): string
    {
        return $this->companyId;
    }
}