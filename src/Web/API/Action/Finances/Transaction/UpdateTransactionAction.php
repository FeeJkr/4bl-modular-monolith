<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction;

use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Transaction\UpdateTransactionRequest;
use App\Web\API\Service\Finances\Transaction\TransactionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class UpdateTransactionAction extends AbstractAction
{
    private TransactionService $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $request = UpdateTransactionRequest::createFromServerRequest($request);

        $this->service->updateTransaction($request);

        return $this->noContentResponse();
    }
}
