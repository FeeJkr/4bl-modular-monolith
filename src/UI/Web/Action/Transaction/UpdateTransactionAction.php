<?php
declare(strict_types=1);

namespace App\UI\Web\Action\Transaction;

use App\Category\SharedKernel\CategoryId;
use App\SharedKernel\Money;
use App\Transaction\Application\Command\UpdateTransactionCommand;
use App\Transaction\Application\TransactionService;
use App\Transaction\SharedKernel\TransactionId;
use App\Transaction\SharedKernel\TransactionType;
use App\UI\Web\Action\Action;
use App\Wallet\SharedKernel\WalletId;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UpdateTransactionAction extends Action
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->transactionService->updateTransaction(
            new UpdateTransactionCommand(
                TransactionId::fromInt((int) $request->get('id')),
                $request->get('user_id'),
                WalletId::fromInt((int) $request->get('wallet_id')),
                $request->get('linked_wallet_id') === null
                    ? WalletId::nullInstance()
                    : WalletId::fromInt((int) $request->get('linked_wallet_id')),
                CategoryId::fromInt((int) $request->get('category_id')),
                new TransactionType($request->get('transaction_type')),
                new Money((int) $request->get('amount')),
                $request->get('description'),
                (new DateTime)->setTimestamp((int) $request->get('operation_at'))
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
