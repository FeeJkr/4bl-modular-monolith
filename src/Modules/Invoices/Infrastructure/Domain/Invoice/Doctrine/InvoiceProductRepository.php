<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice\Doctrine;

use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use Doctrine\DBAL\Connection;
use Throwable;

class InvoiceProductRepository
{
    public function __construct(private Connection $connection){}

    /**
     * @throws Throwable
     */
    public function store(int $invoiceId, InvoiceProductsCollection $products): void
    {
        try {
            /** @var InvoiceProduct $product */
            foreach ($products->getProducts() as $product) {
                $queryBuilder = $this->connection->createQueryBuilder();

                $queryBuilder
                    ->insert('invoice_products')
                    ->values([
                        'invoice_id' => ':invoiceId',
                        'position' => ':position',
                        'name' => ':name',
                        'price' => ':price',
                    ])
                    ->setParameters([
                        'invoiceId' => $invoiceId,
                        'position' => $product->getPosition(),
                        'name' => $product->getName(),
                        'price' => $product->getNetPrice(),
                    ])
                    ->execute();
            }
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}