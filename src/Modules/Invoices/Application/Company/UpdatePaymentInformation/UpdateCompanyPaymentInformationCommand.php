<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\UpdatePaymentInformation;

class UpdateCompanyPaymentInformationCommand
{
    public function __construct(
        private int $companyId,
        private string $paymentType,
        private int $paymentLastDate,
        private string $bank,
        private string $accountNumber,
    ){}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    public function getPaymentLastDate(): int
    {
        return $this->paymentLastDate;
    }

    public function getBank(): string
    {
        return $this->bank;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }
}