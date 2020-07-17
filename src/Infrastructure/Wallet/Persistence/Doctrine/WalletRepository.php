<?php
declare(strict_types=1);

namespace App\Infrastructure\Wallet\Persistence\Doctrine;

use App\DomainModel\Wallet\Wallet;
use App\DomainModel\Wallet\WalletRepository as WalletRepositoryInterface;
use DateTime;
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
}
