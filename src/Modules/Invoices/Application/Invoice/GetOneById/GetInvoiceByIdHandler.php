<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\User\UserContext;

class GetInvoiceByIdHandler implements QueryHandler
{
    public function __construct(private InvoiceRepository $repository, private UserContext $userContext){}

    public function __invoke(GetInvoiceByIdQuery $query): InvoiceDTO
    {
        $invoice = $this->repository->fetchOneById(
            InvoiceId::fromString($query->getInvoiceId()),
            $this->userContext->getUserId()
        );

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
            new InvoiceProductsCollection(
                array_map(
                    static fn(InvoiceProduct $product) => new InvoiceProductDTO(
                        $product->getPosition(),
                        $product->getName(),
                        $product->getNetPrice()
                    ),
                    $invoice->getProducts()->getProducts()
                )
            )
        );
    }
}