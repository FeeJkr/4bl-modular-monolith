<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Invoice;

class InvoiceProductsCollection
{
    public function __construct(private array $products) {}

    public function toArray(): array
    {
        return array_map(
            static fn (InvoiceProduct $product): array => $product->toArray(),
            $this->products
        );
    }

    public function getTotalNetPrice(): float
    {
        return array_sum(
            array_map(
                static fn (InvoiceProduct $product): float => $product->getNetPrice(),
                $this->products
            )
        );
    }

    public function getTotalTaxPrice(): float
    {
        return array_sum(
            array_map(
                static fn (InvoiceProduct $product): float => $product->getTaxPrice(),
                $this->products
            )
        );
    }

    public function getTotalGrossPrice(): float
    {
        return array_sum(
            array_map(
                static fn (InvoiceProduct $product): float => $product->getGrossPrice(),
                $this->products
            )
        );
    }
}