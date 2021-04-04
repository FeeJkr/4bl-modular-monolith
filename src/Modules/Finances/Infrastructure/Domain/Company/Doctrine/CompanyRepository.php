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
                c.account_number,
                ca.id as company_addresses_id,
                ca.street,
                ca.zip_code,
                ca.city
            FROM companies c
                JOIN company_addresses ca ON c.company_addresses_id = ca.id 
            WHERE 
                c.id = :id
        ", [
            'id' => $id->toInt(),
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

    public function fetchAll(): array
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
                c.account_number,
                ca.id as company_addresses_id,
                ca.street,
                ca.zip_code,
                ca.city
            FROM companies c
            JOIN company_addresses ca ON c.company_addresses_id = ca.id;
        ")->fetchAllAssociative();

        return array_map(
            static function (array $company): Company {
                return new Company(
                    CompanyId::fromInt((int) $company['company_id']),
                    $company['name'],
                    new CompanyAddress(
                        CompanyAddressId::fromInt((int) $company['company_addresses_id']),
                        $company['street'],
                        $company['zip_code'],
                        $company['city']
                    ),
                    $company['identification_number'],
                    $company['email'],
                    $company['phone_number'],
                    $company['payment_type'],
                    $company['payment_last_date'],
                    $company['bank'],
                    $company['account_number']
                );
            },
            $data
        );
    }
}
