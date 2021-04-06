<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetOneById;

final class CompanyDTO
{
    public function __construct(
        private int $id,
        private string $name,
        private string $street,
        private string $zipCode,
        private string $city,
        private string $identificationNumber,
        private ?string $email,
        private ?string $phoneNumber,
        private ?string $paymentType,
        private ?int $paymentLastDate,
        private ?string $bank,
        private ?string $accountNumber,
    ){}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    public function getPaymentLastDate(): ?int
    {
        return $this->paymentLastDate;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }
}
