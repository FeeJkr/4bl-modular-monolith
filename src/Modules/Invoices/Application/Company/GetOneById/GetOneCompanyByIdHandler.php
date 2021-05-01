<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class GetOneCompanyByIdHandler implements QueryHandler
{
    public function __construct(private CompanyRepository $repository, private UserContext $userContext){}

    public function __invoke(GetOneCompanyByIdQuery $query): CompanyDTO
    {
        $company = $this->repository->fetchById(
            CompanyId::fromString($query->getCompanyId()),
            $this->userContext->getUserId()
        );

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
    }
}
