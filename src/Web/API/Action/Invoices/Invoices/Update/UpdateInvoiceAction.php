<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\Update;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Invoice\Update\UpdateInvoiceCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateInvoiceAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(Request $serverRequest): Response
    {
		$request = UpdateInvoiceRequest::createFromServerRequest($serverRequest);
		$command = new UpdateInvoiceCommand(
		    $request->getId(),
		    $request->getInvoiceNumber(),
            $request->getGenerateDate(),
            $request->getSellDate(),
            $request->getGeneratePlace(),
            $request->getSellerId(),
            $request->getBuyerId(),
            $request->getProducts(),
            $request->getAlreadyTakenPrice(),
            $request->getCurrencyCode()
		);

		$this->bus->dispatch($command);

		return $this->noContentResponse();
    }
}