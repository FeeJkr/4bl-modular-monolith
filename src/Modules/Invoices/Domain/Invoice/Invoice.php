<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\User\UserId;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Invoice
{
    public function __construct(
        private InvoiceId $id,
        private UserId $userId,
        private Company $seller,
        private Company $buyer,
        private InvoiceParameters $parameters,
        private Collection $products,
        private DateTimeImmutable $createdAt,
        private ?DateTimeImmutable $updatedAt
    ){}

    public static function create(
        UserId $userId,
        Company $seller,
        Company $buyer,
        InvoiceParameters $parameters,
    ): self {
        return new self(
            InvoiceId::generate(),
            $userId,
            $seller,
            $buyer,
            $parameters,
            new ArrayCollection(),
            new DateTimeImmutable(),
            null
        );
    }

    public function setProducts(array $products): void
    {
        $productsCollection = new ArrayCollection();

        foreach ($products as $product) {
            $productsCollection->add(
                new InvoiceProduct(
                    InvoiceProductId::generate(),
                    $this,
                    (int) $product['position'],
                    $product['name'],
                    (float) $product['price'],
                    new DateTimeImmutable(),
                    null,
                )
            );
        }

        $this->products = $productsCollection;
    }

    public function update(
        Company $seller,
        Company $buyer,
        InvoiceParameters $parameters,
        array $products,
    ): void {
        $this->seller = $seller;
        $this->buyer = $buyer;
        $this->parameters = $parameters;
        $this->setProducts($products);
    }

    public function getId(): InvoiceId
    {
        return $this->id;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getSeller(): Company
    {
        return $this->seller;
    }

    public function getBuyer(): Company
    {
        return $this->buyer;
    }

    public function getParameters(): InvoiceParameters
    {
        return $this->parameters;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}