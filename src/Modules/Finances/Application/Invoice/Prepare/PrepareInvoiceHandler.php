<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Invoice\Prepare;

use App\Modules\Finances\Application\Company\GetOneById\CompanyDTO;
use App\Modules\Finances\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Modules\Finances\Domain\Invoice\PriceTransformer;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class PrepareInvoiceHandler
{
    public function __construct(private MessageBusInterface $messageBus, private PriceTransformer $priceTransformer){}

    public function __invoke(PrepareInvoiceCommand $command): InvoiceDTO
    {
        $seller = $this->getInvoiceCompanyDTO($command->getSellerId());
        $buyer = $this->getInvoiceCompanyDTO($command->getBuyerId());
        $products = $this->getInvoiceProductsCollection($command->getProducts());

        return new InvoiceDTO(
            $command->getInvoiceNumber(),
            $command->getGenerateDate(),
            $command->getSellDate(),
            $command->getGeneratePlace(),
            $seller,
            $buyer,
            $products,
            $command->getAlreadyTakenPrice(),
            $this->priceTransformer->transformToText($products->getTotalGrossPrice()),
        );
    }

    private function getInvoiceCompanyDTO(int $companyId): InvoiceCompanyDTO
    {
        /** @var CompanyDTO $company */
        $company = $this->messageBus
            ->dispatch(new GetOneCompanyByIdQuery($companyId))
            ->last(HandledStamp::class)
            ->getResult();

        return new InvoiceCompanyDTO(
            $company->getName(),
            $company->getStreet(),
            $company->getZipCode(),
            $company->getCity(),
            $company->getIdentificationNumber(),
            $company->getEmail(),
            $company->getPhoneNumber(),
            $company->getPaymentType(),
            $company->getPaymentLastDate(),
            $company->getBank(),
            $company->getACcountNumber(),
        );
    }

    private function getInvoiceProductsCollection(array $products): InvoiceProductsCollection
    {
        $productDTOs = [];

        foreach ($products as $product) {
            $productDTOs[] = new InvoiceProductDTO(
                $product['name'],
                (float) $product['net_price'],
            );
        }

        return new InvoiceProductsCollection($productDTOs);
    }
}