<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice\Doctrine;

use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;
use Throwable;

class InvoiceProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvoiceProduct::class);
    }

    /**
     * @throws Throwable
     */
    public function store(InvoiceId $invoiceId, InvoiceProductsCollection $products): void
    {
        foreach ($products->getProducts() as $product) {
            $this->connection
                ->createQueryBuilder()
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
    }

    /**
     * @throws Throwable
     */
    public function update(InvoiceId $invoiceId, InvoiceProductsCollection $products): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete('invoice_products')
            ->where('invoice_id = :invoiceId')
            ->setParameter('invoiceId', $invoiceId->toString())
            ->execute();

        $this->store($invoiceId, $products);
    }
}