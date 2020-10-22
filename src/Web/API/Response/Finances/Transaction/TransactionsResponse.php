<?php
declare(strict_types=1);

namespace App\Web\API\Response\Finances\Transaction;

use App\Modules\Finances\Application\Transaction\GetAll\TransactionDTO;
use App\Modules\Finances\Application\Transaction\GetAll\TransactionsCollection;

final class TransactionsResponse
{
    private array $transactions;

    public function __construct(TransactionResponse ...$transactions)
    {
        $this->transactions = $transactions;
    }

    public static function createFromCollection(TransactionsCollection $collection): self
    {
        $data = [];

        /** @var TransactionDTO $transaction */
        foreach ($collection->getTransactions() as $transaction) {
            $data[] = new TransactionResponse(
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

        return new self(...$data);
    }

    public function getResponse(): array
    {
        return array_map(fn(TransactionResponse $transaction) => $transaction->getResponse(), $this->transactions);
    }
}
