<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\GetOne;

use App\Modules\Invoices\Application\Company\GetOneById\CompanyDTO;
use App\Web\API\Action\Response;

final class GetOneCompanyResponse extends Response
{
    public static function respond(CompanyDTO $companyDTO): self
    {
        return new self([
            'id' => $companyDTO->getId(),
            'name' => $companyDTO->getName(),
            'street' => $companyDTO->getStreet(),
            'zipCode' => $companyDTO->getZipCode(),
            'city' => $companyDTO->getCity(),
            'identificationNumber' => $companyDTO->getIdentificationNumber(),
            'email' => $companyDTO->getEmail(),
            'phoneNumber' => $companyDTO->getPhoneNumber(),
            'paymentType' => $companyDTO->getPaymentType(),
            'paymentLastDate' => $companyDTO->getPaymentLastDate(),
            'bank' => $companyDTO->getBank(),
            'accountNumber' => $companyDTO->getAccountNumber(),
        ]);
    }
}