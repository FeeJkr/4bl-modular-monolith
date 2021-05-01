<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceParameters;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\Invoice\PdfFromHtmlGenerator;
use App\Modules\Invoices\Domain\User\UserContext;
use DateTime;
use JetBrains\PhpStorm\Pure;

class UpdateInvoiceHandler implements CommandHandler
{
    public function __construct(
        private InvoiceRepository $repository,
        private UserContext $userContext,
        private PdfFromHtmlGenerator $pdfFromHtmlGenerator,
    ){}

    public function __invoke(UpdateInvoiceCommand $command): void
    {
        $invoice = $this->repository->fetchOneById(
            InvoiceId::fromString($command->getId()),
            $this->userContext->getUserId()
        );

        $products = $this->getInvoiceProductsCollection($command->getProducts());
        $invoiceParameters = new InvoiceParameters(
            $command->getInvoiceNumber(),
            $command->getSellerId(),
            $command->getBuyerId(),
            $command->getGeneratePlace(),
            $command->getAlreadyTakenPrice(),
            $command->getCurrency(),
            DateTime::createFromFormat('d-m-Y', $command->getGenerateDate()),
            DateTime::createFromFormat('d-m-Y', $command->getSellDate()),
        );

        $invoice->update($invoiceParameters, $products);

        $this->pdfFromHtmlGenerator->generate($invoice);

        $this->repository->save($invoice);
    }

    #[Pure]
    private function getInvoiceProductsCollection(array $products): InvoiceProductsCollection
    {
        $invoiceProducts = [];

        foreach ($products as $product) {
            $invoiceProducts[] = new InvoiceProduct(
                (int) $product['position'],
                $product['name'],
                (float) $product['price'],
            );
        }

        return new InvoiceProductsCollection($invoiceProducts);
    }
}