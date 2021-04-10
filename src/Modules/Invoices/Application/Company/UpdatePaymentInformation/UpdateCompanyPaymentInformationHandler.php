<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\UpdatePaymentInformation;

use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

class UpdateCompanyPaymentInformationHandler
{
    public function __construct(
        private CompanyRepository $repository,
        private UserContext $userContext,
    ){}

    public function __invoke(UpdateCompanyPaymentInformationCommand $command): void
    {
        $company = $this->repository->fetchById(
            CompanyId::fromInt($command->getCompanyId()),
            $this->userContext->getUserId()
        );

        $company->updatePaymentInformation(
            $command->getPaymentType(),
            $command->getPaymentLastDate(),
            $command->getBank(),
            $command->getAccountNumber(),
        );

        $this->repository->save($company);
    }
}