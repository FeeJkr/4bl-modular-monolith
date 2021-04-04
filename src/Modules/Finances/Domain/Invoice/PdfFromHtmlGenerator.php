<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Invoice;

interface PdfFromHtmlGenerator
{
    public function generate(Invoice $invoice): void;
}