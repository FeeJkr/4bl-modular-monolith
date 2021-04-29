<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use DateTimeInterface;

class InvoiceParameters
{
    public function __construct(
        private string $invoiceNumber,
        private int $sellerId,
        private int $buyerId,
        private string $generatePlace,
        private float $alreadyTakenPrice,
        private string $currencyCode,
        private DateTimeInterface $generateDate,
        private DateTimeInterface $sellDate,
    ){}

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function getSellerId(): int
    {
        return $this->sellerId;
    }

    public function getBuyerId(): int
    {
        return $this->buyerId;
    }

    public function getGeneratePlace(): string
    {
        return $this->generatePlace;
    }

    public function getAlreadyTakenPrice(): float
    {
        return $this->alreadyTakenPrice;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function getGenerateDate(): DateTimeInterface
    {
        return $this->generateDate;
    }

    public function getSellDate(): DateTimeInterface
    {
        return $this->sellDate;
    }
}