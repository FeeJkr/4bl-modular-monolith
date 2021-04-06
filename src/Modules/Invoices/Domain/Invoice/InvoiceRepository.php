<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

interface InvoiceRepository
{
    public function store(Invoice $invoice): void;
    public function fetchOneById(InvoiceId $invoiceId, string $token): Invoice;
}
