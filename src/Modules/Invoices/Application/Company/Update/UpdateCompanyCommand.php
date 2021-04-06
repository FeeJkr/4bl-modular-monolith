<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Update;

class UpdateCompanyCommand
{
    public function __construct(
        private int $companyId,
        private string $street,
        private string $zipCode,
        private string $city,
        private string $name,
        private string $identificationNumber,
        private ?string $email,
        private ?string $phoneNumber,
    ){}

    public function getCompanyId(): int
    {
        return $this->companyId;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getIdentificationNumber(): string
    {
        return $this->identificationNumber;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }
}