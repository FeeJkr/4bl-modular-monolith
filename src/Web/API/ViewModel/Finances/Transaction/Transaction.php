<?php
declare(strict_types=1);

namespace App\Web\API\ViewModel\Finances\Transaction;

use DateTimeInterface;
use JsonSerializable;

final class Transaction implements JsonSerializable
{
    private int $id;
    private ?int $linkedTransactionId;
    private int $userId;
    private int $walletId;
    private int $categoryId;
    private string $transactionType;
    private int $amount;
    private ?string $description;
    private DateTimeInterface $operationAt;
    private DateTimeInterface $createdAt;

    public function __construct(
        int $id,
        ?int $linkedTransactionId,
        int $userId,
        int $walletId,
        int $categoryId,
        string $transactionType,
        int $amount,
        ?string $description,
        DateTimeInterface $operationAt,
        DateTimeInterface $createdAt
    ) {
        $this->id = $id;
        $this->linkedTransactionId = $linkedTransactionId;
        $this->userId = $userId;
        $this->walletId = $walletId;
        $this->categoryId = $categoryId;
        $this->transactionType = $transactionType;
        $this->amount = $amount;
        $this->description = $description;
        $this->operationAt = $operationAt;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLinkedTransactionId(): ?int
    {
        return $this->linkedTransactionId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getWalletId(): int
    {
        return $this->walletId;
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

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'linked_transaction_id' => $this->linkedTransactionId,
            'user_id' => $this->userId,
            'wallet_id' => $this->walletId,
            'category_id' => $this->categoryId,
            'transaction_type' => $this->transactionType,
            'amount' => $this->amount,
            'description' => $this->description,
            'operation_at' => $this->operationAt->getTimestamp(),
            'created_at' => $this->createdAt->getTimestamp(),
        ];
    }
}
