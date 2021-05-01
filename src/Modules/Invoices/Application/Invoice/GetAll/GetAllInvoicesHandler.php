<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\User\UserContext;

class GetAllInvoicesHandler implements QueryHandler
{
    public function __construct(private InvoiceRepository $repository, private UserContext $userContext){}

    public function __invoke(GetAllInvoicesQuery $query): InvoicesCollection
    {
        $invoices = array_map(
            static function (Invoice $invoice): InvoiceDTO {
                return new InvoiceDTO(
                    $invoice->getId()->toString(),
                    $invoice->getUserId()->toString(),
                    $invoice->getParameters()->getSellerId(),
                    $invoice->getParameters()->getBuyerId(),
                    $invoice->getParameters()->getInvoiceNumber(),
                    $invoice->getParameters()->getAlreadyTakenPrice(),
                    $invoice->getParameters()->getCurrencyCode(),
                    $invoice->getParameters()->getGenerateDate(),
                    $invoice->getParameters()->getSellDate(),
                );
            },
            $this->repository->fetchAll($this->userContext->getUserId())
        );

        return new InvoicesCollection(array_values($invoices));
    }
}