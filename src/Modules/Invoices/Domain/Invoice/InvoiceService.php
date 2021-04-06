<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

final class InvoiceService
{
    public function __construct(private HtmlGenerator $htmlGenerator, private InvoiceTokenGenerator $tokenGenerator){}

    public function create(InvoiceParameters $invoiceParameters): Invoice
    {
        return Invoice::create(
            $this->htmlGenerator->generate($invoiceParameters),
            $this->tokenGenerator->generate()
        );
    }
}
