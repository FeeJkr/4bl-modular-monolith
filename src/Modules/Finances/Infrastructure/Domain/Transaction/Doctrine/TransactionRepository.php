<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Transaction\Doctrine;

use App\Modules\Finances\Application\Transaction\FetchOneById\TransactionDTO;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\Transaction\LinkedTransaction;
use App\Modules\Finances\Domain\Transaction\Transaction;
use App\Modules\Finances\Domain\Transaction\TransactionException;
use App\Modules\Finances\Domain\Transaction\TransactionId;
use App\Modules\Finances\Domain\Transaction\TransactionRepository as TransactionRepositoryInterface;
use App\Modules\Finances\Domain\Transaction\TransactionType;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletId;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

final class TransactionRepository implements TransactionRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private AdapterInterface $cache;

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

    public function fetchAllByWallet(WalletId $walletId, UserId $userId): Collection
    {
        $collection = new ArrayCollection();
        $data = $this->entityManager->getConnection()->executeQuery("
            WITH wallet_transactions AS (
                SELECT * FROM transactions WHERE wallet_id = :walletId AND user_id = :userId
            ), linked_transactions AS (
                SELECT * FROM transactions WHERE transactions.id IN (SELECT transaction_id FROM wallet_transactions)
            ) SELECT * FROM wallet_transactions UNION SELECT * FROM linked_transactions;
        ", [
            'walletId' => $walletId->toInt(),
            'userId' => $userId->toInt(),
        ])->fetchAll();

        foreach ($data as $transaction) {
            $collection->add($transaction);
        }

        return $collection->map(static function (array $transaction): TransactionDTO {
            return TransactionDTO::createFromArray($transaction);
        });
    }

    public function fetchOneById(TransactionId $transactionId, UserId $userId): TransactionDTO
    {
        $data = $this->entityManager->getConnection()->executeQuery("
            SELECT * FROM transactions 
            WHERE id = :transactionId 
              AND user_id = :userId 
              AND wallet_id IN (SELECT wallet_id FROM wallets_users WHERE user_id = :subQueryWalletId)
        ", [
            'transactionId' => $transactionId->toInt(),
            'userId' => $userId->toInt(),
            'subQueryWalletId' => $userId->toInt(),
        ])->fetch();

        if ($data === false) {
            throw TransactionException::notFound($transactionId, $userId);
        }

        return TransactionDTO::createFromArray($data);
    }

    public function fetchAll(UserId $userId): Collection
    {
        $collection = new ArrayCollection();
        $data = $this->entityManager->getConnection()->executeQuery("
            WITH wallet_transactions AS (
                SELECT * FROM transactions WHERE user_id = :userId
            ), linked_transactions AS (
                SELECT * FROM transactions WHERE transactions.id IN (SELECT transaction_id FROM wallet_transactions)
            ) SELECT * FROM wallet_transactions UNION SELECT * FROM linked_transactions;
        ", [
            'userId' => $userId->toInt(),
        ])->fetchAll();

        foreach ($data as $transaction) {
            $collection->add($transaction);
        }

        return $collection->map(static function (array $transaction): TransactionDTO {
            return TransactionDTO::createFromArray($transaction);
        });
    }
}
