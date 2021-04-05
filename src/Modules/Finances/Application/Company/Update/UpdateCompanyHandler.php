<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Company\Update;

use App\Modules\Finances\Domain\Company\CompanyId;
use App\Modules\Finances\Domain\Company\CompanyRepository;
use App\Modules\Finances\Domain\User\UserContext;

class UpdateCompanyHandler
{
    public function __construct(
        private CompanyRepository $repository,
        private UserContext $userContext,
    ){}

    public function __invoke(UpdateCompanyCommand $command): void
    {
        $company = $this->repository->fetchById(
            CompanyId::fromInt($command->getCompanyId()),
            $this->userContext->getUserId()
        );

        $company->update(
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

        $this->repository->save($company);
    }
}