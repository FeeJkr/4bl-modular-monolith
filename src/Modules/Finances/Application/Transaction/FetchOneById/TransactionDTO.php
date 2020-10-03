<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\FetchOneById;

use App\Common\User\UserId;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\Transaction\TransactionId;
use App\Modules\Finances\Domain\Transaction\TransactionType;
use App\Modules\Finances\Domain\Wallet\WalletId;
use DateTime;
use DateTimeInterface;
use JsonSerializable;

final class TransactionDTO implements JsonSerializable
{
    private TransactionId $id;
    private TransactionId $linkedTransactionId;
    private UserId $userId;
    private WalletId $walletId;
    private CategoryId $categoryId;
    private TransactionType $transactionType;
    private Money $amount;
    private ?string $description;
    private DateTimeInterface $operationAt;
    private DateTimeInterface $createdAt;

    public function __construct(
        TransactionId $id,
        TransactionId $linkedTransactionId,
        UserId $userId,
        WalletId $walletId,
        CategoryId $categoryId,
        TransactionType $transactionType,
        Money $amount,
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

    public static function createFromArray(array $transaction): self
    {
        return new self(
            TransactionId::fromInt($transaction['id']),
            $transaction['transaction_id'] === null
                ? TransactionId::nullInstance()
                : TransactionId::fromInt($transaction['transaction_id']),
            UserId::fromInt($transaction['user_id']),
            WalletId::fromInt($transaction['wallet_id']),
            CategoryId::fromInt($transaction['category_id']),
            new TransactionType($transaction['type']),
            new Money($transaction['amount']),
            $transaction['description'],
            DateTime::createFromFormat('Y-m-d H:i:s', $transaction['operation_at']),
            DateTime::createFromFormat('Y-m-d H:i:s', $transaction['created_at'])
        );
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id->toInt(),
            'transaction_id' => $this->linkedTransactionId->isNull() ? null : $this->linkedTransactionId->toInt(),
            'user_id' => $this->userId->toInt(),
            'wallet_id' => $this->walletId->toInt(),
            'category_id' => $this->categoryId->toInt(),
            'transaction_type' => $this->transactionType->getValue(),
            'amount' => $this->amount->getAmount(),
            'description' => $this->description,
            'operation_at' => $this->operationAt->getTimestamp(),
            'created_at' => $this->operationAt->getTimestamp(),
        ];
    }
}
