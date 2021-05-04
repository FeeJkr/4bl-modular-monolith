<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\User\UserId;
use DateTime;

class Invoice
{
    public function __construct(
        private InvoiceId $id,
        private UserId $userId,
        private CompanyId $sellerId,
        private CompanyId $buyerId,
        private InvoiceParameters $parameters,
        private InvoiceProductsCollection $products,
    ){}

    public static function create(
        UserId $userId,
        CompanyId $sellerId,
        CompanyId $buyerId,
        InvoiceParameters $parameters,
        InvoiceProductsCollection $products,
    ): self {
        return new self(
            InvoiceId::generate(),
            $userId,
            $sellerId,
            $buyerId,
            $parameters,
            $products,
        );
    }

    public static function fromRow(array $rows): self
    {
        $row = $rows[0];

        return new self(
            InvoiceId::fromString($row['id']),
            UserId::fromString($row['user_id']),
            CompanyId::fromString($row['seller_id']),
            CompanyId::fromString($row['buyer_id']),
            new InvoiceParameters(
                $row['invoice_number'],
                $row['generate_place'],
                (float) $row['already_taken_price'],
                $row['currency_code'],
                DateTime::createFromFormat('Y-m-d H:i:s', $row['generated_at']),
                DateTime::createFromFormat('Y-m-d H:i:s', $row['sold_at']),
            ),
            InvoiceProductsCollection::fromRows($rows)
        );
    }

    public function update(
        CompanyId $sellerId,
        CompanyId $buyerId,
        InvoiceParameters $parameters,
        InvoiceProductsCollection $products,
    ): void {
        $this->sellerId = $sellerId;
        $this->buyerId = $buyerId;
        $this->parameters = $parameters;
        $this->products = $products;
    }

    public function getId(): InvoiceId
    {
        return $this->id;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getSellerId(): CompanyId
    {
        return $this->sellerId;
    }

    public function getBuyerId(): CompanyId
    {
        return $this->buyerId;
    }

    public function getParameters(): InvoiceParameters
    {
        return $this->parameters;
    }

    public function getProducts(): InvoiceProductsCollection
    {
        return $this->products;
    }
}