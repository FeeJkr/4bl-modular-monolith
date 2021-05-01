<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

class InvoiceProductsCollection
{
    public function __construct(private array $products) {}

    public function getProducts(): array
    {
        return $this->products;
    }

    public function toArray(): array
    {
        return array_map(
            static fn (InvoiceProduct $product): array => $product->toArray(),
            $this->products
        );
    }

    public static function fromRows(array $rows): self
    {
        return new self(
            array_map(
                static fn(array $row) => InvoiceProduct::fromRow($row),
                $rows
            )
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