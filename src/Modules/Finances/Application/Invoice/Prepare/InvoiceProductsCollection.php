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
        $price = 0;

        /** @var InvoiceProductDTO $product */
        foreach ($this->products as $product) {
            $price += $product->getNetPrice();
        }

        return $price;
    }

    public function getTotalTaxPrice(): float
    {
        $price = 0;

        /** @var InvoiceProductDTO $product */
        foreach ($this->products as $product) {
            $price += $product->getTaxPrice();
        }

        return $price;
    }

    public function getTotalGrossPrice(): float
    {
        $price = 0;

        /** @var InvoiceProductDTO $product */
        foreach ($this->products as $product) {
            $price += $product->getGrossPrice();
        }

        return $price;
    }
}