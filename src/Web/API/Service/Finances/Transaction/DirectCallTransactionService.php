<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\Transaction;

use App\Modules\Finances\Application\Transaction\Contract\TransactionContract;
use App\Modules\Finances\Application\Transaction\Create\CreateTransactionCommand;
use App\Modules\Finances\Application\Transaction\Delete\DeleteTransactionCommand;
use App\Modules\Finances\Application\Transaction\GetAll\GetAllTransactionsQuery;
use App\Modules\Finances\Application\Transaction\GetAllByWallet\GetAllTransactionsByWalletQuery;
use App\Modules\Finances\Application\Transaction\GetOneById\GetOneTransactionByIdQuery;
use App\Modules\Finances\Application\Transaction\Update\UpdateTransactionCommand;
use App\Web\API\Request\Finances\Transaction\CreateTransactionRequest;
use App\Web\API\Request\Finances\Transaction\DeleteTransactionRequest;
use App\Web\API\Request\Finances\Transaction\GetAllTransactionsByWalletIdRequest;
use App\Web\API\Request\Finances\Transaction\GetAllTransactionsRequest;
use App\Web\API\Request\Finances\Transaction\GetTransactionByIdRequest;
use App\Web\API\Request\Finances\Transaction\UpdateTransactionRequest;
use App\Web\API\Response\Finances\Transaction\TransactionResponse;
use App\Web\API\Response\Finances\Transaction\TransactionsByWalletResponse;
use App\Web\API\Response\Finances\Transaction\TransactionsResponse;
use App\Web\API\Service\Finances\User\UserService;
use DateTime;

final class DirectCallTransactionService implements TransactionService
{
    private UserService $userService;
    private TransactionContract $transactionContract;

    public function __construct(UserService $userService, TransactionContract $transactionContract)
    {
        $this->userService = $userService;
        $this->transactionContract = $transactionContract;
    }

    public function createTransaction(CreateTransactionRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $command = new CreateTransactionCommand(
            $userId,
            $request->getWalletId(),
            $request->getLinkedWalletId(),
            $request->getCategoryId(),
            $request->getTransactionType(),
            $request->getAmount(),
            $request->getDescription(),
            (new DateTime)->setTimestamp($request->getOperationAt())
        );

        $this->transactionContract->createTransaction($command);
    }

    public function deleteTransaction(DeleteTransactionRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $command = new DeleteTransactionCommand(
            $request->getTransactionId(),
            $userId
        );

        $this->transactionContract->deleteTransaction($command);
    }

    public function updateTransaction(UpdateTransactionRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $command = new UpdateTransactionCommand(
            $request->getTransactionId(),
            $userId,
            $request->getWalletId(),
            $request->getLinkedWalletId(),
            $request->getCategoryId(),
            $request->getTransactionType(),
            $request->getAmount(),
            $request->getDescription(),
            (new DateTime)->setTimestamp($request->getOperationAt())
        );

        $this->transactionContract->updateTransaction($command);
    }

    public function getAllTransactions(GetAllTransactionsRequest $request): TransactionsResponse
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $query = new GetAllTransactionsQuery($userId);

        return TransactionsResponse::createFromCollection(
            $this->transactionContract->getAllTransactions($query)
        );
    }

    public function getAllTransactionsByWalletId(GetAllTransactionsByWalletIdRequest $request): TransactionsByWalletResponse
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $query = new GetAllTransactionsByWalletQuery(
            $request->getWalletId(),
            $userId
        );

        return TransactionsByWalletResponse::createFromCollection(
            $this->transactionContract->getAllTransactionsByWallet($query)
        );
    }

    public function getTransactionById(GetTransactionByIdRequest $request): TransactionResponse
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $query = new GetOneTransactionByIdQuery($request->getTransactionId(), $userId);

        $transaction = $this->transactionContract->getTransactionById($query);

        return new TransactionResponse(
            $transaction->getId(),
            $transaction->getLinkedTransactionId(),
            $transaction->getUserId(),
            $transaction->getWalletId(),
            $transaction->getCategoryId(),
            $transaction->getTransactionType(),
            $transaction->getAmount(),
            $transaction->getDescription(),
            $transaction->getOperationAt(),
            $transaction->getCreatedAt()
        );
    }
}
