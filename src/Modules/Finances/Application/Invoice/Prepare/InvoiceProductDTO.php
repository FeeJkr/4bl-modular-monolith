<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Invoice\Prepare;

use JetBrains\PhpStorm\Pure;

class InvoiceProductDTO
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
}