<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetAll;

class InvoicesCollection
{
    public function __construct(private array $invoices){}

    public function toArray(): array
    {
        return array_map(
            static fn(InvoiceDTO $invoice) => $invoice->toArray(),
            $this->invoices,
        );
    }

}