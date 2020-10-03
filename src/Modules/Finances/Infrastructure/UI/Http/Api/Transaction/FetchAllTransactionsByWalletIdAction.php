<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Transaction;

use App\Modules\Finances\Application\Transaction\Query\FetchAllTransactionsByWalletQuery;
use App\Modules\Finances\Application\Transaction\TransactionReadModel;
use App\Modules\Finances\Application\Transaction\TransactionService;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchAllTransactionsByWalletIdAction extends AbstractController
{
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchAllTransactionsByWalletQuery(
            WalletId::fromInt((int) $request->get('wallet_id')),
            $request->get('user_id')
        );

        return $this->json(
            $this->transactionService->fetchAllByWallet($query)->toArray()
        );
    }
}
