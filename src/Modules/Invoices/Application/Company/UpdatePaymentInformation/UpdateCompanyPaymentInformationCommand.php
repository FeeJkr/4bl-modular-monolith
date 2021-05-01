<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\UpdatePaymentInformation;

use App\Common\Application\Command\Command;

class UpdateCompanyPaymentInformationCommand implements Command
{
    public function __construct(
        private string $companyId,
        private string $paymentType,
        private int $paymentLastDate,
        private string $bank,
        private string $accountNumber,
    ){}

    public function getCompanyId(): string
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