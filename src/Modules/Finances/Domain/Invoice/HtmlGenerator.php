<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Invoice;

interface HtmlGenerator
{
    public function generate(InvoiceParameters $invoiceParameters): string;
}
