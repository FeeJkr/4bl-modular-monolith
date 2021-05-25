<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Company\Doctrine;

use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyNotFoundException;
use App\Modules\Invoices\Domain\Company\CompanyRepository as CompanyRepositoryInterface;
use App\Modules\Invoices\Domain\User\UserId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Throwable;

final class CompanyRepository extends ServiceEntityRepository implements CompanyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    /**
     * @throws Throwable
     */
    public function fetchById(CompanyId $id, UserId $userId): Company
    {
        /** @var Company|null $company */
        $company = $this->findOneBy(['id' => $id, 'userId' => $userId]);

        if ($company === null) {
            throw new CompanyNotFoundException('Company with given id not found.');
        }

        return $company;
    }

    /**
     * @throws Throwable
     */
    public function fetchAll(UserId $userId): array
    {
        return $this->findBy(['userId' => $userId]);
    }

    /**
     * @throws Throwable
     */
    public function store(Company $company): void
    {
        $this->getEntityManager()->persist($company);
    }

    /**
     * @throws ORMException
     */
    public function delete(CompanyId $companyId, UserId $userId): void
    {
        $company = $this->findOneBy(['id' => $companyId, 'userId' => $userId]);

        if ($company !== null) {
            $this->getEntityManager()->remove($company);
        }
    }
}
