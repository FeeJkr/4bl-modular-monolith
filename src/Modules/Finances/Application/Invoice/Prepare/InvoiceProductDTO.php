<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Invoice\Prepare;

class InvoiceProductDTO
{
    public function __construct(
        private string $name,
        private float $productNetPrice,
        private float $vatPrice,
        private float $grossPrice,
    ){}
}