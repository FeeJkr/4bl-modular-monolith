<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Company\Doctrine;

use App\Modules\Finances\Domain\Company\Company;
use App\Modules\Finances\Domain\Company\CompanyAddress;
use App\Modules\Finances\Domain\Company\CompanyAddressId;
use App\Modules\Finances\Domain\Company\CompanyId;
use App\Modules\Finances\Domain\Company\CompanyRepository as CompanyRepositoryInterface;
use App\Modules\Finances\Domain\User\UserId;
use Doctrine\DBAL\Connection;

final class CompanyRepository implements CompanyRepositoryInterface
{
    public function __construct(private Connection $connection) {}

    public function fetchById(CompanyId $id, UserId $userId): Company
    {
        $data = $this->connection->executeQuery("
            SELECT
                c.id as company_id,
                c.name,
                c.identification_number,
                c.email,
                c.phone_number,
                c.payment_type,
                c.payment_last_date,
                c.bank,
                c.accountNumber,
                ca.id as company_addresses_id,
                ca.street,
                ca.zip_code,
                ca.city
            FROM companies c
                JOIN company_addresses ca ON c.company_addresses_id = ca.id 
            WHERE 
                c.id = :id 
                AND c.users_id = :userId
        ", [
            'id' => $id->toInt(),
            'userId' => $userId->toInt(),
        ])->fetchAssociative();

        return new Company(
            CompanyId::fromInt((int) $data['company_id']),
            $data['name'],
            new CompanyAddress(
                CompanyAddressId::fromInt((int) $data['company_addresses_id']),
                $data['street'],
                $data['zip_code'],
                $data['city']
            ),
            $data['identification_number'],
            $data['email'],
            $data['phone_number'],
            $data['payment_type'],
            $data['payment_last_date'],
            $data['bank'],
            $data['account_number']
        );
    }
}
