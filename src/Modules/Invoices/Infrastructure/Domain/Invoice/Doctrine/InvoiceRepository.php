<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice\Doctrine;

use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository as InvoiceRepositoryInterface;
use App\Modules\Invoices\Domain\User\UserId;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Throwable;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(
        private Connection $connection,
        private InvoiceProductRepository $invoiceProductRepository
    ) {}

    /**
     * @throws Throwable
     */
    public function store(Invoice $invoice): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('invoices')
            ->values([
                'id' => ':id',
                'user_id' => ':userId',
                'seller_company_id' => ':sellerCompanyId',
                'buyer_company_id' => ':buyerCompanyId',
                'invoice_number' => ':invoiceNumber',
                'generate_place' => ':generatePlace',
                'already_taken_price' => ':alreadyTakenPrice',
                'currency_code' => ':currencyCode',
                'generated_at' => ':generatedAt',
                'sold_at' => ':soldAt',
            ])
            ->setParameters([
                'id' => $invoice->getId()->toString(),
                'userId' => $invoice->getUserId()->toString(),
                'sellerCompanyId' => $invoice->getSellerId()->toString(),
                'buyerCompanyId' => $invoice->getBuyerId()->toString(),
                'invoiceNumber' => $invoice->getParameters()->getInvoiceNumber(),
                'generatePlace' => $invoice->getParameters()->getGeneratePlace(),
                'alreadyTakenPrice' => $invoice->getParameters()->getAlreadyTakenPrice(),
                'currencyCode' => $invoice->getParameters()->getCurrencyCode(),
                'generatedAt' => $invoice->getParameters()->getGenerateDate()->format('Y-m-d 00:00:00'),
                'soldAt' => $invoice->getParameters()->getSellDate()->format('Y-m-d 00:00:00'),
            ])
            ->execute();

            $this->invoiceProductRepository->store($invoice->getId(), $invoice->getProducts());
    }

    /**
     * @throws Throwable
     */
    public function fetchAll(UserId $userId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $this->addInvoiceDetails($queryBuilder);

        $rows = $queryBuilder
            ->where('i.user_id = :userId')
            ->setParameter('userId', $userId->toString())
            ->execute()
            ->fetchAllAssociative();

        $result = [];

        foreach ($rows as $row) {
            $result[$row['id']][] = $row;
        }

        return array_map(
            static fn(array $row) => Invoice::fromRow($row),
            $result,
        );
    }

    /**
     * @throws Throwable
     */
    public function fetchOneById(InvoiceId $invoiceId, UserId $userId): Invoice
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $this->addInvoiceDetails($queryBuilder);

        $rows = $queryBuilder
            ->where('i.user_id = :userId')
            ->andWhere('i.id = :invoiceId')
            ->setParameter('userId', $userId->toString())
            ->setParameter('invoiceId', $invoiceId->toString())
            ->execute()
            ->fetchAllAssociative();

        return Invoice::fromRow($rows);
    }

    private function addInvoiceDetails(QueryBuilder $queryBuilder): void
    {
        $queryBuilder->select([
            'i.id',
            'i.user_id',
            'i.seller_company_id as seller_id',
            'i.buyer_company_id as buyer_id',
            'i.invoice_number',
            'i.generate_place',
            'i.already_taken_price',
            'i.currency_code',
            'i.generated_at',
            'i.sold_at',
            'ip.position as product_position',
            'ip.name as product_name',
            'ip.price as product_price',
        ])
            ->from('invoices', 'i')
            ->leftJoin('i', 'invoice_products', 'ip', 'ip.invoice_id = i.id');
    }

    /**
     * @throws Exception
     */
    public function delete(InvoiceId $invoiceId, UserId $userId): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->delete('invoices')
            ->where('id = :invoiceId')
            ->andWhere('user_id = :userId')
            ->setParameter('invoiceId', $invoiceId->toString())
            ->setParameter('userId', $userId->toString())
            ->execute();
    }

    /**
     * @throws Throwable
     */
    public function save(Invoice $invoice): void
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->update('invoices')
            ->set('seller_company_id', ':sellerId')
            ->set('buyer_company_id', ':buyerId')
            ->set('invoice_number', ':invoiceNumber')
            ->set('generate_place', ':generatePlace')
            ->set('already_taken_price', ':alreadyTakenPrice')
            ->set('currency_code', ':currencyCode')
            ->set('generated_at', ':generatedAt')
            ->set('sold_at', ':soldAt')
            ->set('updated_at', ':updatedAt')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameters([
                'id' => $invoice->getId()->toString(),
                'userId' => $invoice->getUserId()->toString(),
                'sellerId' => $invoice->getSellerId()->toString(),
                'buyerId' => $invoice->getBuyerId()->toString(),
                'invoiceNumber' => $invoice->getParameters()->getInvoiceNumber(),
                'generatePlace' => $invoice->getParameters()->getGeneratePlace(),
                'alreadyTakenPrice' => $invoice->getParameters()->getAlreadyTakenPrice(),
                'currencyCode' => $invoice->getParameters()->getCurrencyCode(),
                'generatedAt' => $invoice->getParameters()->getGenerateDate()->format('Y-m-d 00:00:00'),
                'soldAt' => $invoice->getParameters()->getSellDate()->format('Y-m-d 00:00:00'),
                'updatedAt' => (new DateTime)->format('Y-m-d H:i:s'),
            ])
            ->execute();

        $this->invoiceProductRepository->update($invoice->getId(), $invoice->getProducts());
    }
}