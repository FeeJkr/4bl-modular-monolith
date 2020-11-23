<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction\GetAllTransactionsByWalletId;

use App\Modules\Finances\Application\Transaction\GetAllByWallet\TransactionDTO;
use App\Modules\Finances\Application\Transaction\GetAllByWallet\TransactionsByWalletCollection;

final class GetAllTransactionsByWalletIdResponse
{
    private array $transactions;

    public function __construct(array ...$transactions)
    {
        $this->transactions = $transactions;
    }

    public static function createFromCollection(TransactionsByWalletCollection $collection): self
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
