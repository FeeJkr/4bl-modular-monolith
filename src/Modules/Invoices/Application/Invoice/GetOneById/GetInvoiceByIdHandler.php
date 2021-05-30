<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Invoice\InvoiceDTO;
use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\User\UserContext;
use Doctrine\DBAL\Connection;

class GetInvoiceByIdHandler implements QueryHandler
{
    public function __construct(private InvoiceRepository $invoiceRepository, private UserContext $userContext){}

    public function __invoke(GetInvoiceByIdQuery $query): Invoice
    {
        return $this->invoiceRepository->fetchOneById(
            InvoiceId::fromString($query->getInvoiceId()),
            $this->userContext->getUserId()
        );
    }
}