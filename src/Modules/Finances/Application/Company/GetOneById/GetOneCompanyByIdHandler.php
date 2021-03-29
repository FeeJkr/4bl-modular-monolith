<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Company\GetOneById;

use App\Modules\Finances\Domain\Company\CompanyId;
use App\Modules\Finances\Domain\Company\CompanyRepository;
use App\Modules\Finances\Domain\User\UserContext;

final class GetOneCompanyByIdHandler
{
    public function __construct(private CompanyRepository $repository, private UserContext $userContext){}

    public function __invoke(GetOneCompanyByIdQuery $query): CompanyDTO
    {
        $company = $this->repository->fetchById(
            CompanyId::fromInt($query->getCompanyId()),
            $this->userContext->getUserId()
        );

        return new CompanyDTO(
            $company->getId(),
        );
    }
}
