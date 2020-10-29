<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Application\Transaction;

use App\Modules\Finances\Application\Transaction\Create\CreateTransactionCommand;
use App\Modules\Finances\Application\Transaction\Delete\DeleteTransactionCommand;
use App\Modules\Finances\Application\Transaction\GetAll\GetAllTransactionsQuery;
use App\Modules\Finances\Application\Transaction\GetAll\TransactionsCollection;
use App\Modules\Finances\Application\Transaction\GetAllByWallet\GetAllTransactionsByWalletQuery;
use App\Modules\Finances\Application\Transaction\GetAllByWallet\TransactionsByWalletCollection;
use App\Modules\Finances\Application\Transaction\GetOneById\GetOneTransactionByIdQuery;
use App\Modules\Finances\Application\Transaction\GetOneById\TransactionDTO;
use App\Modules\Finances\Application\Transaction\TransactionContract;
use App\Modules\Finances\Application\Transaction\Update\UpdateTransactionCommand;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessageBusTransactionService implements TransactionContract
{
    private MessageBusInterface $bus;

    private function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function createTransaction(CreateTransactionCommand $command): void
    {
        $this->bus->dispatch($command);
    }

    public function deleteTransaction(DeleteTransactionCommand $command): void
    {
        $this->bus->dispatch($command);
    }

    public function updateTransaction(UpdateTransactionCommand $command): void
    {
        $this->bus->dispatch($command);
    }

    public function getAllTransactions(GetAllTransactionsQuery $query): TransactionsCollection
    {
        return $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();
    }

    public function getAllTransactionsByWallet(GetAllTransactionsByWalletQuery $query): TransactionsByWalletCollection
    {
        return $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();
    }

    public function getTransactionById(GetOneTransactionByIdQuery $query): TransactionDTO
    {
        return $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();
    }
}
