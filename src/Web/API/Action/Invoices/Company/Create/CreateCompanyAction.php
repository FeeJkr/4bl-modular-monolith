<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Create;

use App\Modules\Invoices\Application\Company\Create\CreateCompanyCommand;
use App\Web\API\Action\AbstractAction;
use Assert\LazyAssertionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CreateCompanyAction extends AbstractAction
{
    public function __construct(private MessageBusInterface $bus){}

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

		$id = $this->bus
			->dispatch($command)
			->last(HandledStamp::class)
			->getResult();

		return $this->json(['id' => $id]);
    }
}