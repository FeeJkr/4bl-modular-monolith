<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction;

use App\Modules\Finances\Application\Transaction\Create\CreateTransactionCommand;
use App\Modules\Finances\Application\Transaction\Delete\DeleteTransactionCommand;
use App\Modules\Finances\Application\Transaction\GetAll\GetAllTransactionsQuery;
use App\Modules\Finances\Application\Transaction\GetAll\TransactionsCollection;
use App\Modules\Finances\Application\Transaction\GetAllByWallet\GetAllTransactionsByWalletQuery;
use App\Modules\Finances\Application\Transaction\GetAllByWallet\TransactionsByWalletCollection;
use App\Modules\Finances\Application\Transaction\GetOneById\GetOneTransactionByIdQuery;
use App\Modules\Finances\Application\Transaction\GetOneById\TransactionDTO;
use App\Modules\Finances\Application\Transaction\Update\UpdateTransactionCommand;

interface TransactionContract
{
    public function createTransaction(CreateTransactionCommand $command): void;
    public function deleteTransaction(DeleteTransactionCommand $command): void;
    public function updateTransaction(UpdateTransactionCommand $command): void;

    public function getAllTransactions(GetAllTransactionsQuery $query): TransactionsCollection;
    public function getAllTransactionsByWallet(GetAllTransactionsByWalletQuery $query): TransactionsByWalletCollection;
    public function getTransactionById(GetOneTransactionByIdQuery $query): TransactionDTO;
}
