<?php
declare(strict_types=1);

namespace App\UI\Web\Action\Transaction;

use App\Transaction\ReadModel\Query\FetchAllTransactionsByWalletQuery;
use App\Transaction\ReadModel\TransactionReadModel;
use App\UI\Web\Action\Action;
use App\Wallet\SharedKernel\WalletId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchAllTransactionsByWalletIdAction extends Action
{
    private $transactionReadModel;

    public function __construct(TransactionReadModel $transactionReadModel)
    {
        $this->transactionReadModel = $transactionReadModel;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchAllTransactionsByWalletQuery(
            WalletId::fromInt((int) $request->get('wallet_id')),
            $request->get('user_id')
        );

        return $this->json(
            $this->transactionReadModel->fetchAllByWallet($query)->toArray()
        );
    }
}
