<?php
declare(strict_types=1);

namespace App\Application\Transaction\Command;

use App\SharedKernel\Category\CategoryId;
use App\SharedKernel\Money;
use App\SharedKernel\Transaction\TransactionType;
use App\SharedKernel\User\UserId;
use App\SharedKernel\Wallet\WalletId;
use DateTimeInterface;

final class CreateNewTransactionCommand
{
    private $userId;
    private $walletId;
    private $linkedWalletId;
    private $categoryId;
    private $transactionType;
    private $amount;
    private $description;
    private $operationAt;

    public function __construct(
        UserId $userId,
        WalletId $walletId,
        WalletId $linkedWalletId,
        CategoryId $categoryId,
        TransactionType $transactionType,
        Money $amount,
        ?string $description,
        DateTimeInterface $operationAt
    ) {
        $this->userId = $userId;
        $this->walletId = $walletId;
        $this->linkedWalletId = $linkedWalletId;
        $this->categoryId = $categoryId;
        $this->transactionType = $transactionType;
        $this->amount = $amount;
        $this->description = $description;
        $this->operationAt = $operationAt;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getWalletId(): WalletId
    {
        return $this->walletId;
    }

    public function getLinkedWalletId(): WalletId
    {
        return $this->linkedWalletId;
    }

    public function getCategoryId(): CategoryId
    {
        return $this->categoryId;
    }

    public function getTransactionType(): TransactionType
    {
        return $this->transactionType;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getOperationAt(): DateTimeInterface
    {
        return $this->operationAt;
    }
}
