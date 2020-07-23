<?php
declare(strict_types=1);

namespace App\UI\Web\Action\Transaction;

use App\Transaction\ReadModel\Query\FetchOneTransactionByIdQuery;
use App\Transaction\ReadModel\TransactionReadModel;
use App\Transaction\SharedKernel\TransactionId;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchOneTransactionByIdAction extends Action
{
    private $transactionReadModel;

    public function __construct(TransactionReadModel $transactionReadModel)
    {
        $this->transactionReadModel = $transactionReadModel;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchOneTransactionByIdQuery(
            TransactionId::fromInt((int) $request->get('id')),
            $request->get('user_id')
        );

        return $this->json(
            $this->transactionReadModel->fetchOneById($query)
        );
    }
}
