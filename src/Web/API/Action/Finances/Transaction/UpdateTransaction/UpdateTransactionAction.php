<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction\UpdateTransaction;

use App\Modules\Finances\Application\Transaction\Update\UpdateTransactionCommand;
use App\Web\API\Action\AbstractAction;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdateTransactionAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $updateTransactionRequest = UpdateTransactionRequest::createFromServerRequest($request);
        $this->bus->dispatch(
            new UpdateTransactionCommand(
                $updateTransactionRequest->getTransactionId(),
                $updateTransactionRequest->getWalletId(),
                $updateTransactionRequest->getLinkedWalletId(),
                $updateTransactionRequest->getCategoryId(),
                $updateTransactionRequest->getTransactionType(),
                $updateTransactionRequest->getAmount(),
                $updateTransactionRequest->getDescription(),
                (new DateTime())->setTimestamp($updateTransactionRequest->getOperationAt())
            )
        );

        return $this->noContentResponse();
    }
}
