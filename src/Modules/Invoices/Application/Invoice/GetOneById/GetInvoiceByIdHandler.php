<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;

class GetInvoiceByIdHandler
{
    public function __construct(private InvoiceRepository $repository){}

    public function __invoke(GetInvoiceByIdQuery $query): InvoiceDTO
    {
        $invoice = $this->repository->fetchOneById(
            InvoiceId::fromInt($query->getInvoiceId()),
            $query->getInvoiceToken()
        );

        return new InvoiceDTO(
            $invoice->getId()->toInt(),
            $invoice->getHtml(),
            $invoice->getToken(),
        );
    }
}