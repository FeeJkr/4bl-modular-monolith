<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Company;

class CompanyPaymentInformation
{
    public function __construct(
        private ?string $paymentType,
        private ?string $paymentLastDate,
        private ?string $bank,
        private ?string $accountNumber,
    ){}

    public function update(?string $paymentType, ?string $paymentLastDate, ?string $bank, ?string $accountNumber): void
    {
        $this->paymentType = $paymentType;
        $this->paymentLastDate = $paymentLastDate;
        $this->bank = $bank;
        $this->accountNumber = $accountNumber;
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