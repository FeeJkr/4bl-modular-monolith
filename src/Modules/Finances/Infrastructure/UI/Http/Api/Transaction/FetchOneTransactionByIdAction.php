<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Transaction;

use App\Modules\Finances\Application\Transaction\Query\FetchOneTransactionByIdQuery;
use App\Modules\Finances\Application\Transaction\TransactionReadModel;
use App\Modules\Finances\Application\Transaction\TransactionService;
use App\Modules\Finances\Domain\Transaction\TransactionId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchOneTransactionByIdAction extends AbstractController
{
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchOneTransactionByIdQuery(
            TransactionId::fromInt((int) $request->get('id')),
            $request->get('user_id')
        );

        return $this->json(
            $this->transactionService->fetchOneById($query)
        );
    }
}
