<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction\GetAllTransactions;

use App\Modules\Finances\Application\Transaction\GetAll\TransactionDTO;
use App\Modules\Finances\Application\Transaction\GetAll\TransactionsCollection;

final class GetAllTransactionsResponse
{
    private array $transactions;

    public function __construct(array ...$transactions)
    {
        $this->transactions = $transactions;
    }

    public static function createFromCollection(TransactionsCollection $collection): self
    {
        $data = [];

        /** @var TransactionDTO $transaction */
        foreach ($collection->getTransactions() as $transaction) {
            $data[] = [
                'id' => $transaction->getId(),
                'linkedTransactionId' => $transaction->getLinkedTransactionId(),
                'userId' => $transaction->getUserId(),
                'walletId' => $transaction->getWalletId(),
                'categoryId' => $transaction->getCategoryId(),
                'type' => $transaction->getTransactionType(),
                'amount' => $transaction->getAmount(),
                'description' => $transaction->getDescription(),
                'operationAt' => $transaction->getOperationAt(),
                'createdAt' => $transaction->getCreatedAt()
            ];
        }

        return new self(...$data);
    }

    public function getResponse(): array
    {
        return $this->transactions;
    }
}
