<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Company\Create;

use App\Modules\Finances\Domain\Company\Company;
use App\Modules\Finances\Domain\Company\CompanyRepository;
use App\Modules\Finances\Domain\User\UserContext;

class CreateCompanyHandler
{
    public function __construct(
        private CompanyRepository $repository,
        private UserContext $userContext
    ){}

    public function __invoke(CreateCompanyCommand $command): void
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
            $command->getPaymentType(),
            $command->getPaymentLastDate(),
            $command->getBank(),
            $command->getAccountNumber(),
        );

        $this->repository->store($company);
    }
}