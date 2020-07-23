<?php
declare(strict_types=1);

namespace App\UI\Web\Action\Transaction;

use App\Transaction\Application\Command\DeleteTransactionCommand;
use App\Transaction\Application\TransactionService;
use App\Transaction\SharedKernel\TransactionId;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class DeleteTransactionAction extends Action
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->transactionService->deleteTransaction(
            new DeleteTransactionCommand(
                TransactionId::fromInt((int) $request->get('id')),
                $request->get('user_id')
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
