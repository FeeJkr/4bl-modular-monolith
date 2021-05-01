<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use JetBrains\PhpStorm\ArrayShape;

class InvoiceProductDTO
{
    public function __construct(private int $position, private string $name, private float $price){}

    #[ArrayShape([
        'position' => "int",
        'name' => "string",
        'price' => "float"
    ])]
    public function toArray(): array
    {
        return [
            'position' => $this->position,
            'name' => $this->name,
            'price' => $this->price,
        ];
    }
}