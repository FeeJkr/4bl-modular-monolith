<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction\GetOneTransactionById;

use App\Modules\Finances\Application\Transaction\GetOneById\TransactionDTO;
use DateTimeInterface;

final class GetOneTransactionByIdResponse
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

    public static function createFromTransaction(TransactionDTO $transactionDTO): self
    {
        return new self(
            $transactionDTO->getId(),
            $transactionDTO->getLinkedTransactionId(),
            $transactionDTO->getUserId(),
            $transactionDTO->getWalletId(),
            $transactionDTO->getCategoryId(),
            $transactionDTO->getTransactionType(),
            $transactionDTO->getAmount(),
            $transactionDTO->getDescription(),
            $transactionDTO->getOperationAt(),
            $transactionDTO->getCreatedAt()
        );
    }

    public function getResponse(): array
    {
        return [
            'id' => $this->id,
            'linkedTransactionId' => $this->linkedTransactionId,
            'userId' => $this->userId,
            'walletId' => $this->walletId,
            'categoryId' => $this->categoryId,
            'transactionType' => $this->transactionType,
            'amount' => $this->amount,
            'description' => $this->description,
            'operationAt' => $this->operationAt->getTimestamp(),
            'createdAt' => $this->createdAt->getTimestamp(),
        ];
    }
}
