<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\UpdatePaymentInformation;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Company\UpdatePaymentInformation\UpdateCompanyPaymentInformationCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateCompanyPaymentInformationAction extends AbstractAction
{
	public function __construct(private CommandBus $bus){}

	public function __invoke(Request $serverRequest): Response
	{
		$request = UpdateCompanyPaymentInformationRequest::createFromServerRequest($serverRequest);

		$this->bus->dispatch(new UpdateCompanyPaymentInformationCommand(
			$request->getId(),
			$request->getPaymentType(),
			$request->getPaymentLastDate(),
			$request->getBank(),
			$request->getAccountNumber()
		));

	    return $this->noContentResponse();
	}
}