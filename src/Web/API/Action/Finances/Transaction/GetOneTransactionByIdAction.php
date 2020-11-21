<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction;

use App\Modules\Finances\Application\Transaction\GetOneById\GetOneTransactionByIdQuery;
use App\Modules\Finances\Application\Transaction\GetOneById\TransactionDTO;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Transaction\GetTransactionByIdRequest;
use App\Web\API\Response\Finances\Transaction\TransactionResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class GetOneTransactionByIdAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $getTransactionByIdRequest = GetTransactionByIdRequest::createFromServerRequest($request);
        /** @var TransactionDTO $transaction */
        $transaction = $this->bus
            ->dispatch(new GetOneTransactionByIdQuery($getTransactionByIdRequest->getTransactionId()))
            ->last(HandledStamp::class)
            ->getResult();

        $response = new TransactionResponse(
            $transaction->getId(),
            $transaction->getLinkedTransactionId(),
            $transaction->getUserId(),
            $transaction->getWalletId(),
            $transaction->getCategoryId(),
            $transaction->getTransactionType(),
            $transaction->getAmount(),
            $transaction->getDescription(),
            $transaction->getOperationAt(),
            $transaction->getCreatedAt()
        );

        return $this->json($response->getResponse());
    }
}
