<?php
declare(strict_types=1);

namespace App\Infrastructure\Transaction\Persistence\Doctrine;

use App\DomainModel\Transaction\LinkedTransaction;
use App\DomainModel\Transaction\Transaction;
use App\DomainModel\Transaction\TransactionException;
use App\DomainModel\Transaction\TransactionRepository as TransactionRepositoryInterface;
use App\SharedKernel\Category\CategoryId;
use App\SharedKernel\Money;
use App\SharedKernel\Transaction\TransactionId;
use App\SharedKernel\Transaction\TransactionType;
use App\SharedKernel\User\UserId;
use App\SharedKernel\Wallet\WalletId;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

// TODO: Add SQL transactions on insert and update queries

final class TransactionRepository implements TransactionRepositoryInterface
{
    private $entityManager;
    private $cache;

    public function __construct(EntityManagerInterface $entityManager, AdapterInterface $cache)
    {
        $this->entityManager = $entityManager;
        $this->cache = $cache;
    }

    public function store(Transaction $transaction): void
    {
        $transactionId = $this->entityManager->getConnection()->executeQuery(
            "INSERT INTO transactions (user_id, wallet_id, category_id, type, amount, description, operation_at, created_at) 
                    VALUES (:userId, :walletId, :categoryId, :type, :amount, :description, :operationAt, :createdAt) 
                    RETURNING id
        ", [
            'userId' => $transaction->getUserId()->toInt(),
            'walletId' => $transaction->getWalletId()->toInt(),
            'categoryId' => $transaction->getCategoryId()->toInt(),
            'type' => $transaction->getType()->getValue(),
            'amount' => $transaction->getAmount()->getAmount(),
            'description' => $transaction->getDescription(),
            'operationAt' => $transaction->getOperationAt()->format('Y-m-d H:i:s'),
            'createdAt' => $transaction->getCreatedAt()->format('Y-m-d H:i:s'),
        ])->fetch();

        if ($transaction->getLinkedTransaction() !== null) {
             $linkedTransactionId = $this->entityManager->getConnection()->executeQuery("
                INSERT INTO transactions (transaction_id, user_id, wallet_id, category_id, type, amount, description, operation_at, created_at)
                VALUES (:transactionId, :userId, :walletId, :categoryId, :type, :amount, :description, :operationAt, :createdAt)
                RETURNING id;
             ", [
                 'transactionId' => $transactionId['id'],
                 'userId' => $transaction->getUserId()->toInt(),
                 'walletId' => $transaction->getLinkedTransaction()->getWalletId()->toInt(),
                 'categoryId' => $transaction->getCategoryId()->toInt(),
                 'type' => $transaction->getType()->getValue(),
                 'amount' => $transaction->getLinkedTransaction()->getAmount()->getAmount(),
                 'description' => $transaction->getDescription(),
                 'operationAt' => $transaction->getOperationAt()->format('Y-m-d H:i:s'),
                 'createdAt' => $transaction->getCreatedAt()->format('Y-m-d H:i:s'),
             ])->fetch()['id'];

             $this->entityManager->getConnection()->executeQuery(
                 "UPDATE transactions SET transaction_id = :transactionId WHERE id = :id",
                 [
                     'transactionId' => $linkedTransactionId,
                     'id' => $transactionId['id'],
                 ]
             );
        }

        $this->cache->clear('transactions');
    }

    public function delete(TransactionId $transactionId, UserId $userId): void
    {
        $this->entityManager->getConnection()->executeQuery(
            "DELETE FROM transactions WHERE user_id = :userId AND (transaction_id = :transactionId OR id = :id)",
            [
                'userId' => $userId->toInt(),
                'transactionId' => $transactionId->toInt(),
                'id' => $transactionId->toInt(),
            ]
        );

        $this->cache->clear('transactions');
    }

    public function save(Transaction $transaction): void
    {
        $linkedTransactionId = TransactionId::nullInstance();

        if ($transaction->getLinkedTransaction() !== null) {
            if ($transaction->getLinkedTransaction()->getId()->isNull()) {
                $data = $this->entityManager->getConnection()->executeQuery("
                    INSERT INTO transactions (transaction_id, user_id, wallet_id, category_id, type, amount, description, operation_at, created_at)
                    VALUES (:transactionId, :userId, :walletId, :categoryId, :type, :amount, :description, :operationAt, :createdAt)
                    RETURNING id;
                ", [
                    'transactionId' => $transaction->getId()->toInt(),
                    'userId' => $transaction->getUserId()->toInt(),
                    'walletId' => $transaction->getLinkedTransaction()->getWalletId()->toInt(),
                    'categoryId' => $transaction->getCategoryId()->toInt(),
                    'type' => $transaction->getType()->getValue(),
                    'amount' => $transaction->getLinkedTransaction()->getAmount()->getAmount(),
                    'description' => $transaction->getDescription(),
                    'operationAt' => $transaction->getOperationAt()->format('Y-m-d H:i:s'),
                    'createdAt' => $transaction->getCreatedAt()->format('Y-m-d H:i:s'),
                ])->fetch()['id'];

                $linkedTransactionId = TransactionId::fromInt($data);
            } else {
                $this->entityManager->getConnection()->executeQuery("
                    UPDATE transactions SET 
                        user_id = :userId, 
                        wallet_id = :walletId, 
                        category_id = :categoryId, 
                        type = :type, 
                        amount = :amount, 
                        description = :description, 
                        operation_at = :operationAt 
                    WHERE id = :id
                ", [
                    'id' => $transaction->getLinkedTransaction()->getId()->toInt(),
                    'userId' => $transaction->getUserId()->toInt(),
                    'walletId' => $transaction->getLinkedTransaction()->getWalletId()->toInt(),
                    'categoryId' => $transaction->getCategoryId()->toInt(),
                    'type' => $transaction->getType()->getValue(),
                    'amount' => $transaction->getLinkedTransaction()->getAmount()->getAmount(),
                    'description' => $transaction->getDescription(),
                    'operationAt' => $transaction->getOperationAt()->format('Y-m-d H:i:s'),
                ]);

                $linkedTransactionId = $transaction->getLinkedTransaction()->getId();
            }
        } else {
            $this->entityManager->getConnection()->executeQuery("
                DELETE FROM transactions WHERE transaction_id = :id
            ", [
                'id' => $transaction->getId()->toInt(),
            ]);
        }

        $this->entityManager->getConnection()->executeQuery("
            UPDATE transactions SET 
                transaction_id = :transactionId,
                user_id = :userId, 
                wallet_id = :walletId, 
                category_id = :categoryId, 
                type = :type, 
                amount = :amount, 
                description = :description, 
                operation_at = :operationAt 
            WHERE id = :id
        ", [
            'id' => $transaction->getId()->toInt(),
            'transactionId' => $linkedTransactionId->isNull() ? null : $linkedTransactionId->toInt(),
            'userId' => $transaction->getUserId()->toInt(),
            'walletId' => $transaction->getWalletId()->toInt(),
            'categoryId' => $transaction->getCategoryId()->toInt(),
            'type' => $transaction->getType()->getValue(),
            'amount' => $transaction->getAmount()->getAmount(),
            'description' => $transaction->getDescription(),
            'operationAt' => $transaction->getOperationAt()->format('Y-m-d H:i:s'),
        ]);

        $this->cache->clear('transactions');
    }

    public function fetchById(TransactionId $transactionId, UserId $userId): Transaction
    {
        $data = $this->entityManager->getConnection()->executeQuery("
            SELECT 
                transactions.*,
                linked_transaction.wallet_id as linked_transaction_wallet_id,
                linked_transaction.amount as linked_transaction_amount
            FROM transactions 
                LEFT JOIN transactions linked_transaction ON linked_transaction.transaction_id = transactions.id
            WHERE transactions.id = :transactionId AND transactions.user_id = :userId 
        ", [
            'transactionId' => $transactionId->toInt(),
            'userId' => $userId->toInt(),
        ])->fetch();

        if ($data === false) {
            throw TransactionException::notFound($transactionId, $userId);
        }

        $linkedTransaction = $data['transaction_id'] !== null
            ? new LinkedTransaction(
                TransactionId::fromInt($data['transaction_id']),
                WalletId::fromInt($data['linked_transaction_wallet_id']),
                new Money($data['linked_transaction_amount'])
            )
            : null;

        return new Transaction(
            TransactionId::fromInt($data['id']),
            $linkedTransaction,
            UserId::fromInt($data['user_id']),
            WalletId::fromInt($data['wallet_id']),
            CategoryId::fromInt($data['category_id']),
            new TransactionType($data['type']),
            new Money($data['amount']),
            $data['description'],
            DateTime::createFromFormat('Y-m-d H:i:s', $data['operation_at']),
            DateTime::createFromFormat('Y-m-d H:i:s', $data['created_at'])
        );
    }
}
