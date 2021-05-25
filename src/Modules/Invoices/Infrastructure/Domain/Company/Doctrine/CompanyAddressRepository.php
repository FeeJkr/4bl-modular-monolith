<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Company\Doctrine;

use App\Modules\Invoices\Domain\Company\CompanyAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class CompanyAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyAddress::class);
    }
}