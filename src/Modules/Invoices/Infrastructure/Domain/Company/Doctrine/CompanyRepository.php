<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Company\Doctrine;

use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository as CompanyRepositoryInterface;
use App\Modules\Invoices\Domain\User\UserId;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Throwable;

final class CompanyRepository implements CompanyRepositoryInterface
{
    public function __construct(private Connection $connection) {}

    /**
     * @throws Throwable
     */
    public function fetchById(CompanyId $id, UserId $userId): Company
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select([
                'c.id as company_id',
                'c.user_id',
                'c.name',
                'c.identification_number',
                'c.email',
                'c.phone_number',
                'c.payment_type',
                'c.payment_last_date',
                'c.bank',
                'c.account_number',
                'ca.id as company_address_id',
                'ca.street',
                'ca.zip_code',
                'ca.city',
            ])
            ->from('companies', 'c')
            ->join('c', 'company_addresses', 'ca', 'ca.id = c.company_address_id')
            ->where('c.id = :id')
            ->andWhere('c.user_id = :userId')
            ->setParameter('id', $id->toString())
            ->setParameter('userId', $userId->toString())
            ->execute()
            ->fetchAssociative();

        return Company::fromRow($row);
    }

    /**
     * @throws Throwable
     */
    public function fetchAll(UserId $userId): array
    {
        $rows = $this->connection
            ->createQueryBuilder()
            ->select([
                'c.id as company_id',
                'c.user_id',
                'c.name',
                'c.identification_number',
                'c.email',
                'c.phone_number',
                'c.payment_type',
                'c.payment_last_date',
                'c.bank',
                'c.account_number',
                'ca.id as company_address_id',
                'ca.street',
                'ca.zip_code',
                'ca.city',
            ])
            ->from('companies', 'c')
            ->join('c', 'company_addresses', 'ca', 'ca.id = c.company_address_id')
            ->where('c.user_id = :userId')
            ->setParameter('userId', $userId->toString())
            ->execute()
            ->fetchAllAssociative();

        return array_map(static fn(array $row) => Company::fromRow($row), $rows);
    }

    /**
     * @throws Throwable
     */
    public function store(Company $company): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('company_addresses')
            ->values([
                'id' => ':id',
                'street' => ':street',
                'zip_code' => ':zipCode',
                'city' => ':city',
            ])
            ->setParameters([
                'id' => $company->getCompanyAddressId()->toString(),
                'street' => $company->getStreet(),
                'zipCode' => $company->getZipCode(),
                'city' => $company->getCity(),
            ])
            ->execute();

        $this->connection
            ->createQueryBuilder()
            ->insert('companies')
            ->values([
                'id' => ':id',
                'user_id' => ':userId',
                'company_address_id' => ':companyAddressId',
                'name' => ':name',
                'identification_number' => ':identificationNumber',
                'email' => ':email',
                'phone_number' => ':phoneNumber',
            ])
            ->setParameters([
                'id' => $company->getId()->toString(),
                'userId' => $company->getUserId()->toString(),
                'companyAddressId' => $company->getCompanyAddressId()->toString(),
                'name' => $company->getName(),
                'identificationNumber' => $company->getIdentificationNumber(),
                'email' => $company->getEmail(),
                'phoneNumber' => $company->getPhoneNumber(),
            ])
            ->execute();
    }

    /**
     * @throws Throwable
     */
    public function save(Company $company): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update('company_addresses')
            ->set('street', ':street')
            ->set('zip_code', ':zipCode')
            ->set('city', ':city')
            ->where('id = :id')
            ->setParameters([
                'id' => $company->getCompanyAddressId()->toString(),
                'street' => $company->getStreet(),
                'zipCode' => $company->getZipCode(),
                'city' => $company->getCity(),
            ])
            ->execute();

        $this->connection
            ->createQueryBuilder()
            ->update('companies')
            ->set('name', ':name')
            ->set('identification_number', ':identificationNumber')
            ->set('email', ':email')
            ->set('phone_number', ':phoneNumber')
            ->set('payment_type', ':paymentType')
            ->set('payment_last_date', ':paymentLastDate')
            ->set('bank', ':bank')
            ->set('account_number', ':accountNumber')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameters([
                'id' => $company->getId()->toString(),
                'userId' => $company->getUserId()->toString(),
                'name' => $company->getName(),
                'identificationNumber' => $company->getIdentificationNumber(),
                'email' => $company->getEmail(),
                'phoneNumber' => $company->getPhoneNumber(),
                'paymentType' => $company->getPaymentType(),
                'paymentLastDate' => $company->getPaymentLastDate(),
                'bank' => $company->getBank(),
                'accountNumber' => $company->getAccountNumber(),
            ])
            ->execute();
    }

    /**
     * @throws Exception
     */
    public function delete(CompanyId $id, UserId $userId): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete('companies')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameters([
                'id' => $id->toString(),
                'userId' => $userId->toString(),
            ])
            ->execute();
    }
}
