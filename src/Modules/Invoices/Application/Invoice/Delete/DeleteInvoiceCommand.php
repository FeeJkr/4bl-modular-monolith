<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Delete;

use App\Common\Application\Command\Command;

class DeleteInvoiceCommand implements Command
{
    public function __construct(private string $invoiceId){}

    public function getInvoiceId(): string
    {
        return $this->invoiceId;
    }
}