<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice;

use App\Modules\Invoices\Domain\Invoice\InvoiceTokenGenerator;
use Ramsey\Uuid\Uuid;

class UuidInvoiceTokenGenerator implements InvoiceTokenGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}