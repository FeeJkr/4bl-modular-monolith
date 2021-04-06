<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice\Doctrine;

use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository as InvoiceRepositoryInterface;
use Doctrine\DBAL\Connection;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(private Connection $connection) {}

    public function store(Invoice $invoice): void
    {
        $id = $this->connection->executeQuery("
            INSERT INTO invoices(html, token) VALUES (:html, :token) RETURNING id; 
        ", [
            'html' => $invoice->getHtml(),
            'token' => $invoice->getToken(),
        ])->fetchAssociative()['id'];

        $invoice->setId(InvoiceId::fromInt((int) $id));
    }

    public function fetchOneById(InvoiceId $invoiceId, string $token): Invoice
    {
        $data = $this->connection->executeQuery("
            SELECT id, html, token FROM invoices WHERE id = :id AND token = :token
        ", [
            'id' => $invoiceId->toInt(),
            'token' => $token,
        ])->fetchAssociative();

        return new Invoice(
            InvoiceId::fromInt((int) $data['id']),
            $data['html'],
            $data['token'],
        );
    }
}