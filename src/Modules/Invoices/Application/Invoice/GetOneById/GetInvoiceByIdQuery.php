<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

class GetInvoiceByIdQuery
{
    public function __construct(
        private int $invoiceId,
        private string $invoiceToken,
    ){}

    public function getInvoiceId(): int
    {
        return $this->invoiceId;
    }

    public function getInvoiceToken(): string
    {
        return $this->invoiceToken;
    }
}