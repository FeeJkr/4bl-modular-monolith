<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice\Doctrine;

use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository as InvoiceRepositoryInterface;
use Doctrine\DBAL\Connection;
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
        try {
            $this->connection->beginTransaction();

            $queryBuilder = $this->connection->createQueryBuilder();

            $queryBuilder
                ->insert('invoices')
                ->values([
                    'user_id' => ':userId',
                    'seller_company_id' => ':sellerCompanyId',
                    'buyer_company_id' => ':buyerCompanyId',
                    'invoice_number' => ':invoiceNumber',
                    'already_taken_price' => ':alreadyTakenPrice',
                    'currency_code' => ':currencyCode',
                    'generated_at' => ':generatedAt',
                    'sold_at' => ':soldAt',
                ])
                ->setParameters([
                    'userId' => $invoice->getUserId()->toInt(),
                    'sellerCompanyId' => $invoice->getParameters()->getSellerId(),
                    'buyerCompanyId' => $invoice->getParameters()->getBuyerId(),
                    'invoiceNumber' => $invoice->getParameters()->getInvoiceNumber(),
                    'alreadyTakenPrice' => $invoice->getParameters()->getAlreadyTakenPrice(),
                    'currencyCode' => $invoice->getParameters()->getCurrencyCode(),
                    'generatedAt' => $invoice->getParameters()->getGenerateDate()->format('Y-m-d 00:00:00'),
                    'soldAt' => $invoice->getParameters()->getSellDate()->format('Y-m-d 00:00:00'),
                ])
                ->execute();

                $this->invoiceProductRepository->store(
                    (int) $this->connection->lastInsertId(),
                    $invoice->getProducts()
                );

                $this->connection->commit();
        } catch (Throwable $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }

    public function fetchOneById(InvoiceId $invoiceId, string $token): Invoice
    {
        // implement this method.
    }
}