<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Transaction;

use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\SharedKernel\Money;
use App\SharedKernel\User\UserId;
use DateTime;
use DateTimeInterface;

final class Transaction
{
    private TransactionId $id;
    private ?LinkedTransaction $linkedTransaction;
    private UserId $userId;
    private WalletId $walletId;
    private CategoryId $categoryId;
    private TransactionType $type;
    private Money $amount;
    private ?string $description;
    private DateTimeInterface $operationAt;
    private DateTimeInterface $createdAt;

    public function __construct(
        TransactionId $id,
        ?LinkedTransaction $linkedTransaction,
        UserId $userId,
        WalletId $walletId,
        CategoryId $categoryId,
        TransactionType $type,
        Money $amount,
        ?string $description,
        DateTimeInterface $operationAt,
        DateTimeInterface $createdAt
    ) {
        $this->id = $id;
        $this->linkedTransaction = $linkedTransaction;
        $this->userId = $userId;
        $this->walletId = $walletId;
        $this->categoryId = $categoryId;
        $this->type = $type;
        $this->amount = $amount;
        $this->description = $description;
        $this->operationAt = $operationAt;
        $this->createdAt = $createdAt;
    }

    public static function createNew(
        UserId $userId,
        WalletId $walletId,
        WalletId $linkedWalletId,
        CategoryId $categoryId,
        TransactionType $transactionType,
        Money $amount,
        ?string $description,
        DateTimeInterface $operationAt
    ): self {
        $linkedTransaction = $transactionType->equals(TransactionType::TRANSFER())
            ? LinkedTransaction::createNew($linkedWalletId, $amount->negate())
            : null;

        return new self(
            TransactionId::nullInstance(),
            $linkedTransaction,
            $userId,
            $walletId,
            $categoryId,
            $transactionType,
            $amount,
            $description,
            $operationAt,
            (new DateTime())
        );
    }

    public function update(
        UserId $userId,
        WalletId $walletId,
        WalletId $linkedWalletId,
        CategoryId $categoryId,
        TransactionType $transactionType,
        Money $amount,
        ?string $description,
        DateTimeInterface $operationAt
    ): void {
        if ($transactionType->equals(TransactionType::TRANSFER())) {
            if ($this->linkedTransaction === null) {
                $this->linkedTransaction = LinkedTransaction::createNew(
                    $linkedWalletId,
                    $amount->negate()
                );
            } else {
                $this->linkedTransaction->update($linkedWalletId, $amount->negate());
            }
        } else {
            $this->linkedTransaction = null;
        }

        $this->userId = $userId;
        $this->walletId = $walletId;
        $this->categoryId = $categoryId;
        $this->type = $transactionType;
        $this->amount = $amount;
        $this->description = $description;
        $this->operationAt = $operationAt;
    }

    public function getId(): TransactionId
    {
        return $this->id;
    }

    public function getLinkedTransaction(): ?LinkedTransaction
    {
        return $this->linkedTransaction;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getWalletId(): WalletId
    {
        return $this->walletId;
    }

    public function getCategoryId(): CategoryId
    {
        return $this->categoryId;
    }

    public function getType(): TransactionType
    {
        return $this->type;
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

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
