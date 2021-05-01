<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\GetOne;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Invoice\GetOneById\GetInvoiceByIdQuery;
use App\Modules\Invoices\Application\Invoice\GetOneById\InvoiceDTO;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GetOneInvoiceAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(Request $request): Response
    {
        /** @var InvoiceDTO $invoice */
        $invoice = $this->bus->handle(new GetInvoiceByIdQuery($request->get('id')));

        return $this->json($invoice->toArray());
    }
}