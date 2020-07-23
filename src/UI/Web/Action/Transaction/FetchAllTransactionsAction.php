<?php
declare(strict_types=1);

namespace App\UI\Web\Action\Transaction;

use App\Transaction\ReadModel\Query\FetchAllTransactionsQuery;
use App\Transaction\ReadModel\TransactionReadModel;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchAllTransactionsAction extends Action
{
    private $transactionReadModel;

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
