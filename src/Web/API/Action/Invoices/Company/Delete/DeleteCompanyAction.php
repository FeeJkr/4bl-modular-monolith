<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Delete;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Company\Delete\DeleteCompanyCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteCompanyAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(Request $request): Response
    {
        $deleteCompanyRequest = DeleteCompanyRequest::createFromServerRequest($request);

        $this->bus->dispatch(new DeleteCompanyCommand($deleteCompanyRequest->getCompanyId()));

        return $this->noContentResponse();
    }
}