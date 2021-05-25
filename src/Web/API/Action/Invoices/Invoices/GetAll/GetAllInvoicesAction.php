<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\GetAll;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Invoice\GetAll\GetAllInvoicesQuery;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class GetAllInvoicesAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(): Response
    {
        $invoices = $this->bus->handle(new GetAllInvoicesQuery);

        return $this->json($invoices->toArray());
    }
}