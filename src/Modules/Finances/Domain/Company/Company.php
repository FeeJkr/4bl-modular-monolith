<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Company;

final class Company
{
    public function __construct(
        private CompanyId $id,
        private string $name,
        private CompanyAddress $companyAddress,
        private string $identificationNumber,
        private ?string $email,
        private ?string $phoneNumber,
        private ?string $paymentType,
        private ?string $paymentLastDate,
        private ?string $bank,
        private ?string $accountNumber,
    ){}

    public function getId(): CompanyId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCompanyAddress(): CompanyAddress
    {
        return $this->companyAddress;
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

    public function getPaymentLastDate(): ?string
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