<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Invoice\Prepare;

use App\Modules\Finances\Domain\Invoice\PdfFromHtmlGenerator;
use App\Modules\Finances\Domain\Invoice\InvoiceParameters;
use App\Modules\Finances\Domain\Invoice\InvoiceProduct;
use App\Modules\Finances\Domain\Invoice\InvoiceProductsCollection;
use App\Modules\Finances\Domain\Invoice\InvoiceRepository;
use App\Modules\Finances\Domain\Invoice\InvoiceService;
use App\Modules\Finances\Domain\Invoice\PriceTransformer;

class PrepareInvoiceHandler
{
    public function __construct(
        private PriceTransformer $priceTransformer,
        private InvoiceService $service,
        private InvoiceRepository $repository,
        private PdfFromHtmlGenerator $pdfFromHtmlGenerator,
    ){}

    public function __invoke(PrepareInvoiceCommand $command): void
    {
        $products = $this->getInvoiceProductsCollection($command->getProducts());
        $invoice = $this->service->create(
            new InvoiceParameters(
                $command->getInvoiceNumber(),
                $command->getGenerateDate(),
                $command->getSellDate(),
                $command->getGeneratePlace(),
                $command->getSellerId(),
                $command->getBuyerId(),
                $command->getAlreadyTakenPrice(),
                $this->priceTransformer->transformToText($products->getTotalGrossPrice()),
                $command->getCurrency(),
                $products
            )
        );
        $this->repository->store($invoice);

        $this->pdfFromHtmlGenerator->generate($invoice);
    }

    private function getInvoiceProductsCollection(array $products): InvoiceProductsCollection
    {
        $invoiceProducts = [];

        foreach ($products as $product) {
            $invoiceProducts[] = new InvoiceProduct(
                $product['name'],
                (float) $product['netPrice'],
            );
        }

        return new InvoiceProductsCollection($invoiceProducts);
    }
}