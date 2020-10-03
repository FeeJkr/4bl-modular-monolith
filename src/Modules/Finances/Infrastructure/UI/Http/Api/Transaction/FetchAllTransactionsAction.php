<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Transaction;

use App\Modules\Finances\Application\Transaction\Query\FetchAllTransactionsQuery;
use App\Modules\Finances\Application\Transaction\TransactionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchAllTransactionsAction extends AbstractController
{
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchAllTransactionsQuery(
            $request->get('user_id')
        );

        return $this->json(
            $this->transactionService->fetchAll($query)->toArray()
        );
    }
}
