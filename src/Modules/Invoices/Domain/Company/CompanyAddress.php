<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use JetBrains\PhpStorm\Pure;

final class CompanyAddress
{
    public function __construct(
        private CompanyAddressId $id,
        private string $street,
        private string $zipCode,
        private string $city,
    ){}

    public static function create(string $street, string $zipCode, string $city): self
    {
        return new self(
            CompanyAddressId::generate(),
            $street,
            $zipCode,
            $city,
        );
    }

    #[Pure]
    public static function fromRow(array $row): self
    {
        return new self(
            CompanyAddressId::fromString($row['company_address_id']),
            $row['street'],
            $row['zip_code'],
            $row['city']
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
}
