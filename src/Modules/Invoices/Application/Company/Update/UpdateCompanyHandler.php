<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

class UpdateCompanyHandler implements CommandHandler
{
    public function __construct(
        private CompanyRepository $repository,
        private UserContext $userContext,
    ){}

    public function __invoke(UpdateCompanyCommand $command): void
    {
        $company = $this->repository->fetchById(
            CompanyId::fromString($command->getCompanyId()),
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
        );

        $this->repository->store($company);
    }
}