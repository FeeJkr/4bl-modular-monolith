<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class GetAllCompaniesHandler implements QueryHandler
{
    public function __construct(private CompanyRepository $repository, private UserContext $userContext) {}

    public function __invoke(GetAllCompaniesQuery $query): CompaniesCollection
    {
        $companies = array_map(
            static function (Company $company): CompanyDTO {
                return new CompanyDTO(
                    $company->getId()->toString(),
                    $company->getName(),
                    $company->getStreet(),
                    $company->getZipCode(),
                    $company->getCity(),
                    $company->getIdentificationNumber(),
                    $company->getEmail(),
                    $company->getPhoneNumber(),
                    $company->getPaymentType(),
                    $company->getPaymentLastDate(),
                    $company->getBank(),
                    $company->getAccountNumber(),
                );
            },
            $this->repository->fetchAll($this->userContext->getUserId())
        );

        return new CompaniesCollection($companies);
    }
}
