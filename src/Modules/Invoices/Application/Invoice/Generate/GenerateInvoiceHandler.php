<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Generate;

use App\Common\Application\Command\CommandHandler;
use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductId;
use App\Modules\Invoices\Domain\Invoice\PdfFromHtmlGenerator;
use App\Modules\Invoices\Domain\Invoice\InvoiceParameters;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\User\UserContext;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class GenerateInvoiceHandler implements CommandHandler
{
    public function __construct(
        private InvoiceRepository $repository,
        private PdfFromHtmlGenerator $pdfFromHtmlGenerator,
        private UserContext $userContext,
        private CompanyRepository $companyRepository,
    ){}

    public function __invoke(GenerateInvoiceCommand $command): void
    {
        $invoiceParameters = new InvoiceParameters(
                $command->getInvoiceNumber(),
                $command->getGeneratePlace(),
                $command->getAlreadyTakenPrice(),
                $command->getCurrency(),
                DateTimeImmutable::createFromFormat('d-m-Y', $command->getGenerateDate()),
                DateTimeImmutable::createFromFormat('d-m-Y', $command->getSellDate()),
        );

        $userId = $this->userContext->getUserId();

        $invoice = Invoice::create(
            $userId,
            $this->companyRepository->fetchById(CompanyId::fromString($command->getSellerId()), $userId),
            $this->companyRepository->fetchById(CompanyId::fromString($command->getBuyerId()), $userId),
            $invoiceParameters,
        );

        $invoice->setProducts($command->getProducts());

        $this->pdfFromHtmlGenerator->generate($invoice);

        $this->repository->store($invoice);
    }
}