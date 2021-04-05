<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Invoice;

interface InvoiceTokenGenerator
{
    public function generate(): string;
}