<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Create;

use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

class CreateCompanyHandler
{
    public function __construct(
        private CompanyRepository $repository,
        private UserContext $userContext
    ){}

    public function __invoke(CreateCompanyCommand $command): int
    {
        $company = Company::create(
            $this->userContext->getUserId(),
            $command->getStreet(),
            $command->getZipCode(),
            $command->getCity(),
            $command->getName(),
            $command->getIdentificationNumber(),
            $command->getEmail(),
            $command->getPhoneNumber(),
        );

        $this->repository->store($company);

        return $company->getId()->toInt();
    }
}