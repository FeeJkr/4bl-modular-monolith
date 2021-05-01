<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use App\Common\Application\Query\Query;

class GetInvoiceByIdQuery implements Query
{
    public function __construct(private string $invoiceId){}

    public function getInvoiceId(): string
    {
        return $this->invoiceId;
    }
}