<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Create;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Company\Create\CreateCompanyCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCompanyAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(Request $serverRequest): Response
    {
		$request = CreateCompanyRequest::createFromServerRequest($serverRequest);
		$command = new CreateCompanyCommand(
			$request->getStreet(),
			$request->getZipCode(),
			$request->getCity(),
			$request->getName(),
			$request->getIdentificationNumber(),
			$request->getEmail(),
			$request->getPhoneNumber()
		);

		$this->bus->dispatch($command);

		return $this->noContentResponse();
    }
}