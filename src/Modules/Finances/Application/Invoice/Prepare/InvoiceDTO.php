<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Invoice\Prepare;

final class InvoiceDTO
{
    public function __construct(
        private string $invoiceNumber,
        private string $generateDate,
        private string $sellDate,
        private string $generatePlace,
        private InvoiceCompanyDTO $seller,
        private InvoiceCompanyDTO $buyer,
        private InvoiceProductsCollection $products,
        private float $alreadyTakenPrice,
        private string $translatePrice,
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

    public function getSeller(): InvoiceCompanyDTO
    {
        return $this->seller;
    }

    public function getBuyer(): InvoiceCompanyDTO
    {
        return $this->buyer;
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
}