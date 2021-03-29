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
        private CompanyDTO $seller,
        private CompanyDTO $buyer,
        private InvoiceProductsCollection $products,
        private CompanyPaymentDTO $payment,
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

    public function getSeller(): CompanyDTO
    {
        return $this->seller;
    }

    public function getBuyer(): CompanyDTO
    {
        return $this->buyer;
    }

    public function getProducts(): InvoiceProductsCollection
    {
        return $this->products;
    }

    public function getPayment(): CompanyPaymentDTO
    {
        return $this->payment;
    }
}