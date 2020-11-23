<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction\DeleteTransaction;

use App\Modules\Finances\Application\Transaction\Delete\DeleteTransactionCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteTransactionAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $deleteTransactionRequest = DeleteTransactionRequest::createFromServerRequest($request);
        $this->bus->dispatch(
            new DeleteTransactionCommand(
                $deleteTransactionRequest->getTransactionId()
            )
        );

        return $this->noContentResponse();
    }
}
