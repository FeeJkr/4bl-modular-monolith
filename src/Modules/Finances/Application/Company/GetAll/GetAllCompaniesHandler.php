<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Company\GetAll;

use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\Company\Company;
use App\Modules\Finances\Domain\Company\CompanyRepository;
use App\Modules\Finances\Domain\User\UserContext;

final class GetAllCompaniesHandler
{
    public function __construct(private CompanyRepository $repository) {}

    public function __invoke(GetAllCompaniesQuery $query): CompaniesCollection
    {
        $companies = array_map(
            static function (Company $company): CompanyDTO {
                return new CompanyDTO(
                    $company->getId()->toInt(),
                    $company->getName(),
                    $company->getCompanyAddress()->getStreet(),
                    $company->getCompanyAddress()->getZipCode(),
                    $company->getCompanyAddress()->getCity(),
                    $company->getIdentificationNumber(),
                    $company->getEmail(),
                    $company->getPhoneNumber(),
                    $company->getPaymentType(),
                    $company->getPaymentLastDate(),
                    $company->getBank(),
                    $company->getAccountNumber(),
                );
            },
            $this->repository->fetchAll()
        );

        return new CompaniesCollection($companies);
    }
}
