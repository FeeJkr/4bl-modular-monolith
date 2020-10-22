<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\Transaction;

use App\Web\API\Request\Finances\Transaction\CreateTransactionRequest;
use App\Web\API\Request\Finances\Transaction\DeleteTransactionRequest;
use App\Web\API\Request\Finances\Transaction\FetchAllTransactionsByWalletIdRequest;
use App\Web\API\Request\Finances\Transaction\FetchAllTransactionsRequest;
use App\Web\API\Request\Finances\Transaction\GetTransactionByIdRequest;
use App\Web\API\Request\Finances\Transaction\UpdateTransactionRequest;
use App\Web\API\ViewModel\Finances\Transaction\Transaction;

interface TransactionService
{
    public function createTransaction(CreateTransactionRequest $request): void;
    public function deleteTransaction(DeleteTransactionRequest $request): void;
    public function updateTransaction(UpdateTransactionRequest $request): void;
    public function getAllTransactions(FetchAllTransactionsRequest $request): array;
    public function getAllTransactionsByWalletId(FetchAllTransactionsByWalletIdRequest $request): array;
    public function getTransactionById(GetTransactionByIdRequest $request): Transaction;
}