<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\Delete;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Invoice\Delete\DeleteInvoiceCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteInvoiceAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(Request $request): Response
    {
        $this->bus->dispatch(new DeleteInvoiceCommand($request->get('id')));

        return $this->noContentResponse();
    }
}