<?php
declare(strict_types=1);

namespace App\DomainModel\Transaction;

use App\SharedKernel\Money;
use App\SharedKernel\Transaction\TransactionId;
use App\SharedKernel\Wallet\WalletId;

final class LinkedTransaction
{
    private $id;
    private $walletId;
    private $amount;

    public function __construct(
        TransactionId $id,
        WalletId $walletId,
        Money $amount
    ) {
        $this->id = $id;
        $this->walletId = $walletId;
        $this->amount = $amount;
    }

    public static function createNew(
        WalletId $walletId,
        Money $amount
    ): self {
        return new self(
            TransactionId::nullInstance(),
            $walletId,
            $amount
        );
    }

    public function update(WalletId $walletId, Money $amount): void
    {
        $this->walletId = $walletId;
        $this->amount = $amount;
    }

    public function getId(): TransactionId
    {
        return $this->id;
    }

    public function getWalletId(): WalletId
    {
        return $this->walletId;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }
}
