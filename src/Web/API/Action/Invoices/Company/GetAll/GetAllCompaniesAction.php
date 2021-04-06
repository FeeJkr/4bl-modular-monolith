<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\GetAll;

use App\Modules\Invoices\Application\Company\GetAll\CompaniesCollection;
use App\Modules\Invoices\Application\Company\GetAll\GetAllCompaniesQuery;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GetAllCompaniesAction extends AbstractAction
{
    public function __construct(private MessageBusInterface $bus){}

    public function __invoke(): Response
    {
        /** @var CompaniesCollection $companies */
        $companies = $this->bus->dispatch(new GetAllCompaniesQuery())->last(HandledStamp::class)->getResult();

        return $this->json($companies->toArray());
    }
}