<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Invoice;

use DateTimeInterface;

class InvoiceParameters
{
    public function __construct(
        private string $invoiceNumber,
        private DateTimeInterface $generateDate,
        private DateTimeInterface $sellDate,
        private string $generatePlace,
        private int $sellerId,
        private int $buyerId,
        private float $alreadyTakenPrice,
        private string $translatePrice,
        private string $currencyCode,
        private InvoiceProductsCollection $products,
    ){}

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function getGenerateDate(): DateTimeInterface
    {
        return $this->generateDate;
    }

    public function getSellDate(): DateTimeInterface
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

    public function getProducts(): InvoiceProductsCollection
    {
        return $this->products;
    }

    public function getAlreadyTakenPrice(): float
    {
        return $this->alreadyTakenPrice;
    }

    public function getToPayPrice(): float
    {
        return $this->products->getTotalGrossPrice() - $this->getAlreadyTakenPrice();
    }

    public function getTranslatePrice(): string
    {
        return $this->translatePrice;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }
}