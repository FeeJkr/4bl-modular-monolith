<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Invoice;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class InvoiceProduct
{
    public function __construct(private string $name, private float $netPrice){}

    public function getName(): string
    {
        return $this->name;
    }

    public function getNetPrice(): float
    {
        return $this->netPrice;
    }

    public function getTaxPrice(): float
    {
        return ($this->netPrice * 23) / 100;
    }

    #[Pure]
    public function getGrossPrice(): float
    {
        return $this->netPrice + $this->getTaxPrice();
    }

    #[ArrayShape(['name' => "string", 'netPrice' => "float", 'taxPrice' => "float", 'grossPrice' => "float"])]
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'netPrice' => $this->getNetPrice(),
            'taxPrice' => $this->getTaxPrice(),
            'grossPrice' => $this->getGrossPrice(),
        ];
    }
}