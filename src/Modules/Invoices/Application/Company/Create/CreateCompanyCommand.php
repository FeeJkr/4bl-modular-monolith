<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Create;

class CreateCompanyCommand
{
    public function __construct(
        private string $street,
        private string $zipCode,
        private string $city,
        private string $name,
        private string $identificationNumber,
        private ?string $email,
        private ?string $phoneNumber,
    ){}

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