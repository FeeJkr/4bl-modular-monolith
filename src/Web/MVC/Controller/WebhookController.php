<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller;

use App\Modules\Finances\Application\Filesystem\MoveFileFromApifyToDropbox\MoveFileFromApifyToDropboxCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class WebhookController extends AbstractController
{
    public function __construct(private MessageBusInterface $bus){}

    public function invoiceWasGeneratedFromHtml(Request $request): Response
    {
        $resource = json_decode($request->getContent(), true)['resource'];

        $this->bus->dispatch(new MoveFileFromApifyToDropboxCommand($resource['id'], $resource['actId']));

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}