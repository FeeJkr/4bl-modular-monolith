<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Invoice;

interface InvoiceRepository
{
    public function store(Invoice $invoice): void;
    public function fetchOneById(InvoiceId $invoiceId, string $token): Invoice;
}
