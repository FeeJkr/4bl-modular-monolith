<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Invoice;

use App\Modules\Finances\Application\Company\GetOneById\CompanyDTO;
use App\Modules\Finances\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Modules\Finances\Domain\Invoice\HtmlGenerator;
use App\Modules\Finances\Domain\Invoice\InvoiceParameters;
use DateInterval;
use Exception;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;
use Twig\Environment;

class TwigHtmlGenerator implements HtmlGenerator
{
    public function __construct(private Environment $twig, private MessageBusInterface $bus){}

    public function generate(InvoiceParameters $invoiceParameters): string
    {
        try {
            $seller = $this->getCompanyInformationById($invoiceParameters->getSellerId());
            $buyer = $this->getCompanyInformationById($invoiceParameters->getBuyerId());
            $paymentLastDate = clone $invoiceParameters->getSellDate();
            $paymentLastDate->add(new DateInterval(sprintf('P%dD', $seller->getPaymentLastDate())));

            return $this->twig->render('finances/invoice/invoice.html.twig', [
                'invoiceNumber' => $invoiceParameters->getInvoiceNumber(),
                'generateDate' => $invoiceParameters->getGenerateDate()->format('d-m-Y'),
                'sellDate' => $invoiceParameters->getSellDate()->format('d-m-Y'),
                'generatePlace' => $invoiceParameters->getGeneratePlace(),
                'seller' => [
                    'name' => $seller->getName(),
                    'street' => $seller->getStreet(),
                    'zipCode' => $seller->getZipCode(),
                    'city' => $seller->getCity(),
                    'identificationNumber' => $seller->getIdentificationNumber(),
                    'email' => $seller->getEmail(),
                    'phoneNumber' => $seller->getPhoneNumber(),
                ],
                'buyer' => [
                    'name' => $buyer->getName(),
                    'street' => $buyer->getStreet(),
                    'zipCode' => $buyer->getZipCode(),
                    'city' => $buyer->getCity(),
                    'identificationNumber' => $buyer->getIdentificationNumber(),
                    'email' => $buyer->getEmail(),
                    'phoneNumber' => $buyer->getPhoneNumber(),
                ],
                'products' => $invoiceParameters->getProducts()->toArray(),
                'totalNetPrice' => $invoiceParameters->getProducts()->getTotalNetPrice(),
                'totalTaxPrice' => $invoiceParameters->getProducts()->getTotalTaxPrice(),
                'totalGrossPrice' => $invoiceParameters->getProducts()->getTotalGrossPrice(),
                'paymentType' => $seller->getPaymentType(),
                'paymentLastDate' => $paymentLastDate->format('d-m-Y'),
                'paymentBankName' => $seller->getBank(),
                'paymentAccountNumber' => $seller->getAccountNumber(),
                'alreadyTakenPrice' => $invoiceParameters->getAlreadyTakenPrice(),
                'toPayPrice' => $invoiceParameters->getToPayPrice(),
                'currencyCode' => $invoiceParameters->getCurrencyCode(),
                'translatePrice' => $invoiceParameters->getTranslatePrice(),
            ]);
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    private function getCompanyInformationById(int $companyId): CompanyDTO
    {
        return $this->bus
            ->dispatch(new GetOneCompanyByIdQuery($companyId))
            ->last(HandledStamp::class)
            ->getResult();
    }
}