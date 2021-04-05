<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Company\Doctrine;

use App\Modules\Finances\Domain\Company\Company;
use App\Modules\Finances\Domain\Company\CompanyAddress;
use App\Modules\Finances\Domain\Company\CompanyAddressId;
use App\Modules\Finances\Domain\Company\CompanyId;
use App\Modules\Finances\Domain\Company\CompanyPaymentInformation;
use App\Modules\Finances\Domain\Company\CompanyRepository as CompanyRepositoryInterface;
use App\Modules\Finances\Domain\User\UserId;
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
                new CompanyPaymentInformation(
                    $data['payment_type'],
                    $data['payment_last_date'],
                    $data['bank'],
                    $data['account_number']
                ),
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
                        new CompanyPaymentInformation(
                            $company['payment_type'],
                            $company['payment_last_date'],
                            $company['bank'],
                            $company['account_number']
                        ),
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

        $this->connection->executeQuery(
            'INSERT INTO companies (
                user_id, 
                company_address_id, 
                name, 
                identification_number,
                email,
                phone_number,
                payment_type,
                payment_last_date,
                bank,
                account_number
            ) VALUES (
                :userId,
                :companyAddressId,
                :name,
                :identificationNumber,
                :email,
                :phoneNumber,
                :paymentType,
                :paymentLastDate,
                :bank,
                :accountNumber
            )',
            [
                'userId' => $company->getUserId()->toInt(),
                'companyAddressId' => $companyAddressId,
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
            WHERE id = :id
            ',
            [
                'id' => $company->getId()->toInt(),
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
