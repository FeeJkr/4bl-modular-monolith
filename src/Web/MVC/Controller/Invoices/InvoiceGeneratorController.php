<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller\Invoices;

use App\Modules\Invoices\Application\Company\GetAll\CompaniesCollection;
use App\Modules\Invoices\Application\Company\GetAll\GetAllCompaniesQuery;
use App\Modules\Invoices\Application\Invoice\Prepare\PrepareInvoiceCommand;
use App\Web\MVC\Controller\AbstractController;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class InvoiceGeneratorController extends AbstractController
{
    public function __construct(private Client $client, private MessageBusInterface $bus){}

    public function showGenerateInvoicePage(): Response
    {
        /** @var CompaniesCollection $companies */
        $companies = $this->bus
            ->dispatch(new GetAllCompaniesQuery())
            ->last(HandledStamp::class)
            ->getResult();

        return $this->render('invoices/invoice/generate.html.twig', [
            'companies' => $companies->toArray(),
        ]);
    }

    public function generateInvoice(Request $request): Response
    {
        $command = new PrepareInvoiceCommand(
            $request->get('invoiceNumber'),
            $request->get('generateDate'),
            $request->get('sellDate'),
            $request->get('generatePlace'),
            (int) $request->get('sellerId'),
            (int) $request->get('buyerId'),
            $request->get('products'),
            (float) $request->get('alreadyTakenPrice'),
            $request->get('currencyCode'),
        );

        $this->bus->dispatch($command);

        return $this->redirectToRoute('invoices.company.showAll');
    }
}
