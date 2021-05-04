<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Filesystem\GetFileByName;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Filesystem\GetFileByName\GetFileByNameQuery;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetFileByNameAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(Request $serverRequest): Response
    {
        $request = GetFileByNameRequest::createFromServerRequest($serverRequest);

        $file = $this->bus->handle(new GetFileByNameQuery($request->getFilename()));

        return new Response($file, headers: [
            'Content-Type' => 'application/octet-stream',
        ]);
    }
}