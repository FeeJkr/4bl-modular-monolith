<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use App\Modules\Invoices\Domain\User\UserId;
use JetBrains\PhpStorm\Pure;

final class Company
{
    public function __construct(
        private CompanyId $id,
        private UserId $userId,
        private CompanyAddress $companyAddress,
        private string $name,
        private string $identificationNumber,
        private ?string $email,
        private ?string $phoneNumber,
        private ?CompanyPaymentInformation $paymentInformation
    ){}

    public static function create(
        UserId $userId,
        string $street,
        string $zipCode,
        string $city,
        string $name,
        string $identificationNumber,
        ?string $email,
        ?string $phoneNumber,
    ): self {
        return new self(
            CompanyId::generate(),
            $userId,
            CompanyAddress::create($street, $zipCode, $city),
            $name,
            $identificationNumber,
            $email,
            $phoneNumber,
            null
        );
    }

    public static function fromRow(array $row): self
    {
        return new self(
            CompanyId::fromString($row['company_id']),
            UserId::fromString($row['user_id']),
            CompanyAddress::fromRow($row),
            $row['name'],
            $row['identification_number'],
            $row['email'],
            $row['phone_number'],
            CompanyPaymentInformation::createFromRow($row),
        );
    }

    public function update(
        string $street,
        string $zipCode,
        string $city,
        string $name,
        string $identificationNumber,
        ?string $email,
        ?string $phoneNumber,
    ): void {
        $this->companyAddress->update($street, $zipCode, $city);

        $this->name = $name;
        $this->identificationNumber = $identificationNumber;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }

    public function updatePaymentInformation(
        string $paymentType,
        int $paymentLastDate,
        string $bank,
        string $accountNumber
    ): void {
    	if ($this->paymentInformation === null) {
    		$this->paymentInformation = new CompanyPaymentInformation(
    			$paymentType,
				$paymentLastDate,
				$bank,
				$accountNumber
			);

    		return;
		}

        $this->paymentInformation->update($paymentType, $paymentLastDate, $bank, $accountNumber);
    }

    public function getId(): CompanyId
    {
        return $this->id;
    }

    public function setId(CompanyId $id): void
	{
		$this->id = $id;
	}

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    #[Pure]
    public function getCompanyAddressId(): CompanyAddressId
    {
        return $this->companyAddress->getId();
    }

    public function getName(): string
    {
        return $this->name;
    }

    #[Pure]
    public function getStreet(): string
    {
        return $this->companyAddress->getStreet();
    }

    #[Pure]
    public function getZipCode(): string
    {
        return $this->companyAddress->getZipCode();
    }

    #[Pure]
    public function getCity(): string
    {
        return $this->companyAddress->getCity();
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

    #[Pure]
    public function getPaymentType(): ?string
    {
        return $this->paymentInformation?->getPaymentType();
    }

    #[Pure]
    public function getPaymentLastDate(): ?int
    {
        return $this->paymentInformation?->getPaymentLastDate();
    }

    #[Pure]
    public function getBank(): ?string
    {
        return $this->paymentInformation?->getBank();
    }

    #[Pure]
    public function getAccountNumber(): ?string
    {
        return $this->paymentInformation?->getAccountNumber();
    }
}
