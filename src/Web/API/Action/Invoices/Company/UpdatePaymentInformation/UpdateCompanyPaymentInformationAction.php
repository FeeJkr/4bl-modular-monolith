<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\UpdatePaymentInformation;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Company\UpdatePaymentInformation\UpdateCompanyPaymentInformationCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

class UpdateCompanyPaymentInformationAction extends AbstractAction
{
	public function __construct(private CommandBus $bus){}

	public function __invoke(UpdateCompanyPaymentInformationRequest $request): NoContentResponse
	{
		$this->bus->dispatch(new UpdateCompanyPaymentInformationCommand(
			$request->getId(),
			$request->getPaymentType(),
			$request->getPaymentLastDate(),
			$request->getBank(),
			$request->getAccountNumber()
		));

	    return NoContentResponse::respond();
	}
}