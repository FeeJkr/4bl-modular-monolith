<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

interface InvoiceTokenGenerator
{
    public function generate(): string;
}