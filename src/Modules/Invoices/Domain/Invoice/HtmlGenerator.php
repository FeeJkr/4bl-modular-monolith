<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

interface HtmlGenerator
{
    public function generate(Invoice $invoice): string;
}
