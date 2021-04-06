<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Company\Doctrine;

use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyAddress;
use App\Modules\Invoices\Domain\Company\CompanyAddressId;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyPaymentInformation;
use App\Modules\Invoices\Domain\Company\CompanyRepository as CompanyRepositoryInterface;
use App\Modules\Invoices\Domain\User\UserId;
use Doctrine\DBAL\Connection;
use Throwable;

final class CompanyRepository implements CompanyRepositoryInterface
{
    public function __construct(private Connection $connection) {}

    public function fetchById(CompanyId $id, UserId $userId): Company
    {
        try {
            $data = $this->connection->executeQuery("
                SELECT
                    c.id as company_id,
                    c.user_id,
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
                    JOIN company_addresses ca ON c.company_address_id = ca.id 
                WHERE
                    c.id = :id
                    AND c.user_id = :userId
            ", [
                'id' => $id->toInt(),
                'userId' => $userId->toInt(),
            ])->fetchAssociative();

            return new Company(
                CompanyId::fromInt((int) $data['company_id']),
                UserId::fromInt((int) $data['user_id']),
                new CompanyAddress(
                    CompanyAddressId::fromInt((int) $data['company_addresses_id']),
                    $data['street'],
                    $data['zip_code'],
                    $data['city']
                ),
                $data['name'],
                $data['identification_number'],
                $data['email'],
                $data['phone_number'],
                CompanyPaymentInformation::createFromRow($data)
            );
        } catch (Throwable $exception) {
            // TODO: exception handler
        }
    }

    public function fetchAll(UserId $userId): array
    {
        try {
            $data = $this->connection->executeQuery("
            SELECT
                c.id as company_id,
                c.user_id,
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
            JOIN company_addresses ca ON c.company_address_id = ca.id
            WHERE c.user_id = :userId;
        ", [
                'userId' => $userId->toInt(),
            ])->fetchAllAssociative();

            return array_map(
                static function (array $company): Company {
                    return new Company(
                        CompanyId::fromInt((int) $company['company_id']),
                        UserId::fromInt((int) $company['user_id']),
                        new CompanyAddress(
                            CompanyAddressId::fromInt((int) $company['company_addresses_id']),
                            $company['street'],
                            $company['zip_code'],
                            $company['city']
                        ),
                        $company['name'],
                        $company['identification_number'],
                        $company['email'],
                        $company['phone_number'],
                        CompanyPaymentInformation::createFromRow($company),
                    );
                },
                $data
            );
        } catch (Throwable $exception) {
            // TODO: exception handler
        }
    }

    public function store(Company $company): void
    {
        $companyAddressId = $this->connection->executeQuery(
            'INSERT INTO company_addresses (street, zip_code, city) VALUES (:street, :zipCode, :city) RETURNING id',
            [
                'street' => $company->getStreet(),
                'zipCode' => $company->getZipCode(),
                'city' => $company->getCity(),
            ]
        )->fetchAssociative()['id'];

        $companyId = $this->connection->executeQuery(
            'INSERT INTO companies (
                user_id, 
                company_address_id, 
                name, 
                identification_number,
                email,
                phone_number
            ) VALUES (
                :userId,
                :companyAddressId,
                :name,
                :identificationNumber,
                :email,
                :phoneNumber
            ) RETURNING id',
            [
                'userId' => $company->getUserId()->toInt(),
                'companyAddressId' => $companyAddressId,
                'name' => $company->getName(),
                'identificationNumber' => $company->getIdentificationNumber(),
                'email' => $company->getEmail(),
                'phoneNumber' => $company->getPhoneNumber(),
            ]
        )->fetchAssociative()['id'];

        $company->setId(CompanyId::fromInt((int) $companyId));
    }

    public function save(Company $company): void
    {
        $this->connection->executeQuery('
            UPDATE company_addresses 
            SET
                street = :street,
                zip_code = :zipCode,
                city = :city
            WHERE id = :id
            ',
            [
                'id' => $company->getCompanyAddressId()->toInt(),
                'street' => $company->getStreet(),
                'zipCode' => $company->getZipCode(),
                'city' => $company->getCity(),
            ]
        );

        $this->connection->executeQuery('
            UPDATE companies
            SET
                name = :name,
                identification_number = :identificationNumber,
                email = :email,
                phone_number = :phoneNumber,
                payment_type = :paymentType,
                payment_last_date = :paymentLastDate,
                bank = :bank,
                account_number = :accountNumber
            WHERE id = :id AND user_id = :userId
            ',
            [
                'id' => $company->getId()->toInt(),
                'userId' => $company->getUserId()->toInt(),
                'name' => $company->getName(),
                'identificationNumber' => $company->getIdentificationNumber(),
                'email' => $company->getEmail(),
                'phoneNumber' => $company->getPhoneNumber(),
                'paymentType' => $company->getPaymentType(),
                'paymentLastDate' => $company->getPaymentLastDate(),
                'bank' => $company->getBank(),
                'accountNumber' => $company->getAccountNumber(),
            ]
        );
    }

    public function delete(CompanyId $id, UserId $userId): void
    {
        $this->connection->executeQuery(
            'DELETE FROM companies WHERE id = :id AND user_id = :userId',
            [
                'id' => $id->toInt(),
                'userId' => $userId->toInt(),
            ]
        );
    }
}
