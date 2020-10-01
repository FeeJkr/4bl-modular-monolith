<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Transaction;

use App\Modules\Finances\Application\Transaction\Command\DeleteTransactionCommand;
use App\Modules\Finances\Application\Transaction\TransactionService;
use App\Modules\Finances\Domain\Transaction\TransactionId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class DeleteTransactionAction extends AbstractController
{
    private TransactionService $transactionService;

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
