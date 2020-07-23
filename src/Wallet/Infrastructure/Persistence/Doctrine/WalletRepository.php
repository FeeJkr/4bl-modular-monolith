<?php
declare(strict_types=1);

namespace App\Wallet\Infrastructure\Persistence\Doctrine;

use App\SharedKernel\Money;
use App\SharedKernel\User\UserId;
use App\Wallet\Domain\Wallet;
use App\Wallet\Domain\WalletException;
use App\Wallet\Domain\WalletRepository as WalletRepositoryInterface;
use App\Wallet\SharedKernel\WalletId;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

final class WalletRepository implements WalletRepositoryInterface
{
    private $cache;
    private $entityManager;

    public function __construct(AdapterInterface $cache, EntityManagerInterface $entityManager)
    {
        $this->cache = $cache;
        $this->entityManager = $entityManager;
    }

    public function store(Wallet $wallet): void
    {
        $data = $this->entityManager->getConnection()->executeQuery("
            INSERT INTO wallets (name, start_balance, created_at) VALUES (:name, :startBalance, :createdAt) RETURNING id;
        ", [
            'name' => $wallet->getName(),
            'startBalance' => $wallet->getStartBalance()->getAmount(),
            'createdAt' => (new DateTime())->format('Y-m-d H:i:s'),
        ])->fetch();

        $this->entityManager->getConnection()->executeQuery("
            INSERT INTO wallets_users (wallet_id, user_id) VALUES (:walletId, :userId)
        ", [
            'walletId' => $data['id'],
            'userId' => $wallet->getUserIds()->first()->toInt(),
        ]);

        $this->cache->clear('wallets');
    }

    public function delete(WalletId $walletId, UserId $userId): void
    {
        $rowsDeleted = $this->entityManager->getConnection()->executeQuery("
            DELETE FROM wallets WHERE id = (SELECT wallet_id FROM wallets_users WHERE wallet_id = :walletId AND user_id = :userId)
        ", [
            'walletId' => $walletId->toInt(),
            'userId' => $userId->toInt(),
        ])->rowCount();

        if ($rowsDeleted === 0) {
            throw WalletException::notDeleted($walletId, $userId);
        }

        $this->cache->clear('wallets');
    }

    public function fetchById(WalletId $walletId, UserId $userId): Wallet
    {
        $data = $this->entityManager->getConnection()->executeQuery("
            SELECT
                wallets.*,
                (SELECT string_agg(user_id::text, ', ') FROM wallets_users WHERE wallet_id = wallets.id) as user_ids
            FROM wallets
                LEFT JOIN wallets_users ON wallets.id = wallets_users.wallet_id
            WHERE wallets_users.user_id = :userId AND wallets.id = :walletId;
        ", [
            'userId' => $userId->toInt(),
            'walletId' => $walletId->toInt(),
        ])->fetch();

        if ($data === false) {
            throw WalletException::notFound($walletId, $userId);
        }

        return new Wallet(
            WalletId::fromInt($data['id']),
            $data['name'],
            new Money($data['start_balance']),
            (new ArrayCollection(explode(', ', $data['user_ids'])))->map(static function (string $id): UserId {
                return UserId::fromInt((int) $id);
            })
        );
    }

    public function save(Wallet $wallet): void
    {
        $this->entityManager->getConnection()->executeQuery("
            UPDATE wallets SET name = :name, start_balance = :startBalance WHERE id = :id;
        ", [
            'name' => $wallet->getName(),
            'startBalance' => $wallet->getStartBalance()->getAmount(),
            'id' => $wallet->getId()->toInt(),
        ]);

        $this->entityManager->getConnection()->executeQuery("
            DELETE FROM wallets_users WHERE wallet_id = :id;
        ", [
            'id' => $wallet->getId()->toInt(),
        ]);

        $insertIds = $wallet->getUserIds()->map(static function (UserId $userId) use ($wallet): string {
            return "({$wallet->getId()->toInt()}, {$userId->toInt()})";
        })->getValues();

        $this->entityManager->getConnection()->executeQuery("
            INSERT INTO wallets_users (wallet_id, user_id) VALUES " . implode(', ', $insertIds) . ";
        ");

        $this->cache->clear('wallets');
    }
}
