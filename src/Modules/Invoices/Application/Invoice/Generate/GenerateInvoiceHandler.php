<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Generate;

use App\Common\Application\Command\CommandHandler;
use App\Common\Infrastructure\Messenger\MessageHandlerInterface;
use App\Modules\Invoices\Domain\Invoice\HtmlGenerator;
use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\PdfFromHtmlGenerator;
use App\Modules\Invoices\Domain\Invoice\InvoiceParameters;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\User\UserContext;
use DateTime;
use JetBrains\PhpStorm\Pure;

class GenerateInvoiceHandler implements CommandHandler
{
    public function __construct(
        private InvoiceRepository $repository,
        private PdfFromHtmlGenerator $pdfFromHtmlGenerator,
        private UserContext $userContext,
    ){}

    public function __invoke(GenerateInvoiceCommand $command): void
    {
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

        $invoice = Invoice::create(
            $this->userContext->getUserId(),
            $invoiceParameters,
            $products,
        );

        $this->pdfFromHtmlGenerator->generate($invoice);

        $this->repository->store($invoice);
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