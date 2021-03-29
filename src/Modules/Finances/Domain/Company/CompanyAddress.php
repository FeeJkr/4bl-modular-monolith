<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Company;

final class CompanyAddress
{
    public function __construct(
        private CompanyAddressId $id,
        private string $street,
        private string $zipCode,
        private string $city,
    ){}

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
