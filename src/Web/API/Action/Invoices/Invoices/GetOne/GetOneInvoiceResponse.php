<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\GetOne;

use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Web\API\Action\Response;
use Doctrine\Common\Collections\Collection;

final class GetOneInvoiceResponse extends Response
{
    public static function respond(Invoice $invoice): self
    {
        return new self([
            'id' => $invoice->getId()->toString(),
            'userId' => $invoice->getUserId()->toString(),
            'seller' => [
                'id' => $invoice->getSeller()->getId()->toString(),
                'name' => $invoice->getSeller()->getName(),
            ],
            'buyer' => [
                'id' => $invoice->getBuyer()->getId()->toString(),
                'name' => $invoice->getBuyer()->getName(),
            ],
            'invoiceNumber' => $invoice->getParameters()->getInvoiceNumber(),
            'alreadyTakenPrice' => $invoice->getParameters()->getAlreadyTakenPrice(),
            'generatePlace' => $invoice->getParameters()->getGeneratePlace(),
            'currencyCode' => $invoice->getParameters()->getCurrencyCode(),
            'generatedAt' => $invoice->getParameters()->getGenerateDate()->format('d-m-Y'),
            'soldAt' => $invoice->getParameters()->getSellDate()->format('d-m-Y'),
            'products' => self::buildProducts($invoice->getProducts()),
            'totalNetPrice' => array_sum(
                $invoice->getProducts()->map(static fn(InvoiceProduct $product) => $product->getNetPrice())->toArray()
            ),
        ]);
    }

    private static function buildProducts(Collection $products): array
    {
        return $products->map(static fn(InvoiceProduct $product) => [
            'position' => $product->getPosition(),
            'name' => $product->getName(),
            'price' => $product->getNetPrice(),
        ])->toArray();
    }
}