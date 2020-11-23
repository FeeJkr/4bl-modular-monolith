<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction\GetAllTransactionsByWalletId;

use App\Modules\Finances\Application\Transaction\GetAllByWallet\GetAllTransactionsByWalletQuery;
use App\Modules\Finances\Application\Transaction\GetAllByWallet\TransactionsByWalletCollection;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class GetAllTransactionsByWalletIdAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $getAllTransactionsByWalletRequest = GetAllTransactionsByWalletIdRequest::createFromServerRequest($request);
        /** @var TransactionsByWalletCollection $transactions */
        $transactions = $this->bus
            ->dispatch(new GetAllTransactionsByWalletQuery($getAllTransactionsByWalletRequest->getWalletId()))
            ->last(HandledStamp::class)
            ->getResult();

        $response = GetAllTransactionsByWalletIdResponse::createFromCollection($transactions);

        return $this->json(
            $response->getResponse()
        );
    }
}
