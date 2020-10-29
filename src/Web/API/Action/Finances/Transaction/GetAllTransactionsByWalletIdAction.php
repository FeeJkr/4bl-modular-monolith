<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction;

use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Transaction\GetAllTransactionsByWalletIdRequest;
use App\Web\API\Service\Finances\Transaction\TransactionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class GetAllTransactionsByWalletIdAction extends AbstractAction
{
    private TransactionService $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $getAllTransactionsByWalletRequest = GetAllTransactionsByWalletIdRequest::createFromServerRequest($request);

        $data = $this->service->getAllTransactionsByWalletId($getAllTransactionsByWalletRequest);

        return $this->json($data->getResponse());
    }
}
