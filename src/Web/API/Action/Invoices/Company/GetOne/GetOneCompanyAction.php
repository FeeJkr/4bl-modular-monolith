<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\GetOne;

use App\Modules\Invoices\Application\Company\GetOneById\CompanyDTO;
use App\Modules\Invoices\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GetOneCompanyAction extends AbstractAction
{
	public function __construct(private MessageBusInterface $bus){}

	public function __invoke(Request $request): Response
	{
		/** @var CompanyDTO $companyDTO */
		$companyDTO = $this->bus
			->dispatch(new GetOneCompanyByIdQuery((int) $request->get('id')))
			->last(HandledStamp::class)
			->getResult();

		return $this->json(GetOneCompanyPresenter::present($companyDTO));
	}
}