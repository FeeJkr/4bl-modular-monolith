<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Command;

use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Transaction\TransactionType;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\SharedKernel\Money;
use App\SharedKernel\User\UserId;
use DateTimeInterface;

final class CreateTransactionCommand
{
    private UserId $userId;
    private WalletId $walletId;
    private WalletId $linkedWalletId;
    private CategoryId $categoryId;
    private TransactionType $transactionType;
    private Money $amount;
    private ?string $description;
    private DateTimeInterface $operationAt;

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
