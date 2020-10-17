<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\FetchAllByWallet;

final class TransactionsCollection
{
    /** @var array|TransactionDTO */
    private array $transactions;

    public function __construct(array $transactions)
    {
        $this->transactions = $transactions;
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }
}
