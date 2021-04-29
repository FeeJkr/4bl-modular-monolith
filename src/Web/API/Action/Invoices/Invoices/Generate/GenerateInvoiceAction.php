<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\Generate;

use App\Modules\Invoices\Application\Invoice\Generate\GenerateInvoiceCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class GenerateInvoiceAction extends AbstractAction
{
    public function __construct(private MessageBusInterface $bus){}

    public function __invoke(Request $serverRequest): Response
    {
		$request = GenerateInvoiceRequest::createFromServerRequest($serverRequest);
		$command = new GenerateInvoiceCommand(
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