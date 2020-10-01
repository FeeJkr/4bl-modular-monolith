<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Transaction\Doctrine;

use App\Common\User\UserId;
use App\Modules\Finances\Application\Transaction\TransactionDTO;
use App\Modules\Finances\Application\Transaction\TransactionReadModelException;
use App\Modules\Finances\Application\Transaction\TransactionReadModelRepository as TransactionReadModelRepositoryInterface;
use App\Modules\Finances\Domain\Transaction\TransactionId;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

final class TransactionReadModelRepository implements TransactionReadModelRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
            throw TransactionReadModelException::notFound($transactionId, $userId);
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
