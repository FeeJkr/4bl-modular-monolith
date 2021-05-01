<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetAll;

use DateTimeInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class InvoiceDTO
{
    public function __construct(
        private string $id,
        private string $userId,
        private string $sellerId,
        private string $buyerId,
        private string $invoiceNumber,
        private float $alreadyTakenPrice,
        private string $currencyCode,
        private DateTimeInterface $generatedAt,
        private DateTimeInterface $soldAt,
    ) {}

    #[ArrayShape([
        'id' => "string",
        'userId' => "string",
        'sellerId' => "string",
        'buyerId' => "string",
        'invoiceNumber' => "string",
        'alreadyTakenPrice' => "float",
        'currencyCode' => "string",
        'generatedAt' => "string",
        'soldAt' => "string"
    ])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'sellerId' => $this->sellerId,
            'buyerId' => $this->buyerId,
            'invoiceNumber' => $this->invoiceNumber,
            'alreadyTakenPrice' => $this->alreadyTakenPrice,
            'currencyCode' => $this->currencyCode,
            'generatedAt' => $this->generatedAt->format('d-m-Y'),
            'soldAt' => $this->soldAt->format('d-m-Y'),
        ];
    }
}