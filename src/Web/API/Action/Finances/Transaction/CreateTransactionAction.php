<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction;

use App\Modules\Finances\Application\Transaction\Create\CreateTransactionCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Transaction\CreateTransactionRequest;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateTransactionAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $createTransactionRequest = CreateTransactionRequest::createFromServerRequest($request);
        $this->bus->dispatch(
            new CreateTransactionCommand(
                $createTransactionRequest->getWalletId(),
                $createTransactionRequest->getLinkedWalletId(),
                $createTransactionRequest->getCategoryId(),
                $createTransactionRequest->getTransactionType(),
                $createTransactionRequest->getAmount(),
                $createTransactionRequest->getDescription(),
                (new DateTime)->setTimestamp($createTransactionRequest->getOperationAt())
            )
        );

        return $this->noContentResponse();
    }
}
