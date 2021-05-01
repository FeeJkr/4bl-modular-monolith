<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\GetOne;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Company\GetOneById\CompanyDTO;
use App\Modules\Invoices\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GetOneCompanyAction extends AbstractAction
{
	public function __construct(private QueryBus $bus){}

	public function __invoke(Request $request): Response
	{
		/** @var CompanyDTO $companyDTO */
		$companyDTO = $this->bus->handle(new GetOneCompanyByIdQuery($request->get('id')));

		return $this->json(GetOneCompanyPresenter::present($companyDTO));
	}
}