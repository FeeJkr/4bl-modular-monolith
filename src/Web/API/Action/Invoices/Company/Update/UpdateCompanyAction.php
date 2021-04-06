<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Update;

use App\Modules\Invoices\Application\Company\Update\UpdateCompanyCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class UpdateCompanyAction extends AbstractAction
{
	public function __construct(private MessageBusInterface $bus){}

	public function __invoke(Request $serverRequest): Response
	{
		$request = UpdateCompanyRequest::createFromServerRequest($serverRequest);

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

		return $this->noContentResponse();
	}
}