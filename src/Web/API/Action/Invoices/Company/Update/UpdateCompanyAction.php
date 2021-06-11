<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Update;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Company\Update\UpdateCompanyCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

class UpdateCompanyAction extends AbstractAction
{
	public function __construct(private CommandBus $bus){}

	public function __invoke(UpdateCompanyRequest $request): NoContentResponse
	{
		$this->bus->dispatch(new UpdateCompanyCommand(
			$request->getCompanyId(),
			$request->getStreet(),
			$request->getZipCode(),
			$request->getCity(),
			$request->getName(),
			$request->getIdentificationNumber(),
			$request->getEmail(),
			$request->getPhoneNumber(),
		));

		return NoContentResponse::respond();
	}
}