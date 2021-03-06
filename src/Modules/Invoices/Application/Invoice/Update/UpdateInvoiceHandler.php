<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceParameters;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\Invoice\PdfFromHtmlGenerator;
use App\Modules\Invoices\Domain\User\UserContext;
use DateTime;
use DateTimeImmutable;
use JetBrains\PhpStorm\Pure;

class UpdateInvoiceHandler implements CommandHandler
{
    public function __construct(
        private InvoiceRepository $repository,
        private UserContext $userContext,
        private PdfFromHtmlGenerator $pdfFromHtmlGenerator,
        private CompanyRepository $companyRepository,
    ){}

    public function __invoke(UpdateInvoiceCommand $command): void
    {
        $invoice = $this->repository->fetchOneById(
            InvoiceId::fromString($command->getId()),
            $this->userContext->getUserId()
        );

        $invoiceParameters = new InvoiceParameters(
            $command->getInvoiceNumber(),
            $command->getGeneratePlace(),
            $command->getAlreadyTakenPrice(),
            $command->getCurrency(),
            DateTimeImmutable::createFromFormat('d-m-Y', $command->getGenerateDate()),
            DateTimeImmutable::createFromFormat('d-m-Y', $command->getSellDate()),
        );

        $invoice->update(
            $this->companyRepository->fetchById(CompanyId::fromString($command->getSellerId()), $invoice->getUserId()),
            $this->companyRepository->fetchById(CompanyId::fromString($command->getBuyerId()), $invoice->getUserId()),
            $invoiceParameters,
            $command->getProducts()
        );

        $this->pdfFromHtmlGenerator->generate($invoice);

        $this->repository->store($invoice);
    }
}