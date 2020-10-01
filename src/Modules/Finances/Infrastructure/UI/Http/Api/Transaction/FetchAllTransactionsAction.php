<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Transaction;

use App\Modules\Finances\Application\Transaction\Query\FetchAllTransactionsQuery;
use App\Modules\Finances\Application\Transaction\TransactionReadModel;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchAllTransactionsAction extends Action
{
    private TransactionReadModel $transactionReadModel;

    public function __construct(TransactionReadModel $transactionReadModel)
    {
        $this->transactionReadModel = $transactionReadModel;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchAllTransactionsQuery(
            $request->get('user_id')
        );

        return $this->json(
            $this->transactionReadModel->fetchAll($query)->toArray()
        );
    }
}
