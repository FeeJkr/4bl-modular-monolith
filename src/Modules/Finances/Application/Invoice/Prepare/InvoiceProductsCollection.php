<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Invoice\Prepare;

class InvoiceProductsCollection
{
    public function __construct(private array $products) {}

    public function toArray(): array
    {
        return $this->products;
    }

    public function getTotalNetPrice(): float
    {

    }

    public function getTotalTaxPrice(): float
    {

    }

    public function getTotalGrossPrice(): float
    {

    }
}