<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Invoice\Prepare;

final class PrepareInvoiceCommand
{
    public function __construct(
        private string $invoiceNumber,
        private string $generateDate,
        private string $sellDate,
        private string $generatePlace,
        private int $sellerId,
        private int $buyerId,
        private array $products,
        private float $alreadyTakenPrice,
        private string $currency
    ){}

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function getGenerateDate(): string
    {
        return $this->generateDate;
    }

    public function getSellDate(): string
    {
        return $this->sellDate;
    }

    public function getGeneratePlace(): string
    {
        return $this->generatePlace;
    }

    public function getSellerId(): int
    {
        return $this->sellerId;
    }

    public function getBuyerId(): int
    {
        return $this->buyerId;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getAlreadyTakenPrice(): float
    {
        return $this->alreadyTakenPrice;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
