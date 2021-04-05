<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Company\Delete;

use App\Modules\Finances\Domain\Company\CompanyId;
use App\Modules\Finances\Domain\Company\CompanyRepository;
use App\Modules\Finances\Domain\User\UserContext;

class DeleteCompanyHandler
{
    public function __construct(
        private CompanyRepository $repository,
        private UserContext $userContext,
    ){}

    public function __invoke(DeleteCompanyCommand $command): void
    {
        $this->repository->delete(
            CompanyId::fromInt($command->getCompanyId()),
            $this->userContext->getUserId(),
        );
    }
}