<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use App\Modules\Invoices\Domain\User\UserId;
use DateTime;
use JetBrains\PhpStorm\Pure;

class Invoice
{
    public function __construct(
        private InvoiceId $id,
        private UserId $userId,
        private InvoiceParameters $parameters,
        private InvoiceProductsCollection $products,
    ){}

    public static function create(
        UserId $userId,
        InvoiceParameters $parameters,
        InvoiceProductsCollection $products,
    ): self {
        return new self(
            InvoiceId::generate(),
            $userId,
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
            new InvoiceParameters(
                $row['invoice_number'],
                $row['seller_id'],
                $row['buyer_id'],
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
        InvoiceParameters $parameters,
        InvoiceProductsCollection $products
    ): void {
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

    public function getParameters(): InvoiceParameters
    {
        return $this->parameters;
    }

    public function getProducts(): InvoiceProductsCollection
    {
        return $this->products;
    }
}