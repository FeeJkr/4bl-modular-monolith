<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller\Invoices;

use App\Modules\Invoices\Application\Company\Create\CreateCompanyCommand;
use App\Modules\Invoices\Application\Company\Delete\DeleteCompanyCommand;
use App\Modules\Invoices\Application\Company\GetAll\CompaniesCollection;
use App\Modules\Invoices\Application\Company\GetAll\GetAllCompaniesQuery;
use App\Modules\Invoices\Application\Company\GetOneById\CompanyDTO;
use App\Modules\Invoices\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Web\MVC\Controller\AbstractController;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

class CompanyController extends AbstractController
{
	public function __construct(private MessageBusInterface $bus)
	{
	}

	public function list(): Response
	{
		/** @var CompaniesCollection $companies */
		$companies = $this->bus->dispatch(new GetAllCompaniesQuery())->last(HandledStamp::class)->getResult();

		return $this->render('invoices/company/index.html.twig', [
			'companies' => $companies->toArray(),
		]);
	}

	public function create(): Response
	{
		return $this->render('invoices/company/create.html.twig');
	}

	public function edit(Request $request): Response
	{
		/** @var CompanyDTO $company */
		$company = $this->bus
			->dispatch(new GetOneCompanyByIdQuery((int)$request->get('id')))
			->last(HandledStamp::class)
			->getResult();

		return $this->render('invoices/company/edit.html.twig', [
			'company' => $company,
		]);
	}
}