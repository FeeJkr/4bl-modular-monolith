<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use DateTimeImmutable;

class CompanyAddress
{
    public function __construct(
        private CompanyAddressId $id,
        private string $street,
        private string $zipCode,
        private string $city,
        private DateTimeImmutable $createdAt,
        private ?DateTimeImmutable $updatedAt
    ){}

    public static function create(string $street, string $zipCode, string $city): self
    {
        return new self(
            CompanyAddressId::generate(),
            $street,
            $zipCode,
            $city,
            new DateTimeImmutable(),
            null
        );
    }

    public function update(string $street, string $zipCode, string $city): void
    {
        $this->street = $street;
        $this->zipCode = $zipCode;
        $this->city = $city;
    }

    public function getId(): CompanyAddressId
    {
        return $this->id;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
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
