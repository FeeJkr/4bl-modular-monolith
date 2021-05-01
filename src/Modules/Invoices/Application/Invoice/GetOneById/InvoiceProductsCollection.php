<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

class InvoiceProductsCollection
{
    public function __construct(private array $products){}

    public function toArray(): array
    {
        return array_map(
            static fn(InvoiceProductDTO $product) => $product->toArray(),
            $this->products
        );
    }
}