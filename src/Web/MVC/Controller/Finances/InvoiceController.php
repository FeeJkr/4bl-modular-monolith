<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller\Finances;

use App\Modules\Finances\Application\Invoice\GetOneById\GetInvoiceByIdQuery;
use App\Modules\Finances\Application\Invoice\GetOneById\InvoiceDTO;
use App\Web\MVC\Controller\AbstractController;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class InvoiceController extends AbstractController
{
    public function __construct(private Client $client, private MessageBusInterface $bus){}

    public function renderInvoice(Request $request): Response
    {
        $query = new GetInvoiceByIdQuery(
            (int) $request->get('id'),
            $request->get('invoiceToken')
        );
        /** @var InvoiceDTO $invoice */
        $invoice = $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return new Response($invoice->getHtml());
    }
}
