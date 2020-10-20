<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Update;

use DateTimeInterface;

final class UpdateTransactionCommand
{
    private int $transactionId;
    private int $userId;
    private int $walletId;
    private ?int $linkedWalletId;
    private int $categoryId;
    private string $transactionType;
    private int $amount;
    private ?string $description;
    private DateTimeInterface $operationAt;

    public function __construct(
        int $transactionId,
        int $userId,
        int $walletId,
        ?int $linkedWalletId,
        int $categoryId,
        string $transactionType,
        int $amount,
        ?string $description,
        DateTimeInterface $operationAt
    ) {
        $this->transactionId = $transactionId;
        $this->userId = $userId;
        $this->walletId = $walletId;
        $this->linkedWalletId = $linkedWalletId;
        $this->categoryId = $categoryId;
        $this->transactionType = $transactionType;
        $this->amount = $amount;
        $this->description = $description;
        $this->operationAt = $operationAt;
    }

    public function getTransactionId(): int
    {
        return $this->transactionId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getWalletId(): int
    {
        return $this->walletId;
    }

    public function getLinkedWalletId(): ?int
    {
        return $this->linkedWalletId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    public function getAmount(): int
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
