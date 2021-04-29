<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use App\Modules\Invoices\Domain\User\UserId;
use JetBrains\PhpStorm\Pure;

class Invoice
{
    public function __construct(
        private InvoiceId $id,
        private UserId $userId,
        private InvoiceParameters $parameters,
        private InvoiceProductsCollection $products,
    ){}

    #[Pure]
    public static function create(
        UserId $userId,
        InvoiceParameters $parameters,
        InvoiceProductsCollection $products,
    ): self {
        return new self(
            InvoiceId::nullInstance(),
            $userId,
            $parameters,
            $products,
        );
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