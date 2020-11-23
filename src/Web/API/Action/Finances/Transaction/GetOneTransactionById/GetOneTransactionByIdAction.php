<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction\GetOneTransactionById;

use App\Modules\Finances\Application\Transaction\GetOneById\GetOneTransactionByIdQuery;
use App\Modules\Finances\Application\Transaction\GetOneById\TransactionDTO;
use App\Web\API\Action\AbstractAction;
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
        $getTransactionByIdRequest = GetOneTransactionByIdRequest::createFromServerRequest($request);
        /** @var TransactionDTO $transaction */
        $transaction = $this->bus
            ->dispatch(new GetOneTransactionByIdQuery($getTransactionByIdRequest->getTransactionId()))
            ->last(HandledStamp::class)
            ->getResult();

        $response = GetOneTransactionByIdResponse::createFromTransaction($transaction);

        return $this->json(
            $response->getResponse()
        );
    }
}
