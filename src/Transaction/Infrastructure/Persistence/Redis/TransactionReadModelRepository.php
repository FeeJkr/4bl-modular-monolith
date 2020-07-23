<?php
declare(strict_types=1);

namespace App\Transaction\Infrastructure\Persistence\Redis;

use App\SharedKernel\User\UserId;
use App\Transaction\ReadModel\TransactionDTO;
use App\Transaction\ReadModel\TransactionReadModelRepository as TransactionReadModelRepositoryInterface;
use App\Transaction\SharedKernel\TransactionId;
use App\Wallet\SharedKernel\WalletId;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Cache\Adapter\AdapterInterface;

final class TransactionReadModelRepository implements TransactionReadModelRepositoryInterface
{
    private $cache;
    private $databaseRepository;

    public function __construct(AdapterInterface $cache, TransactionReadModelRepositoryInterface $databaseRepository)
    {
        $this->cache = $cache;
        $this->databaseRepository = $databaseRepository;
    }

    public function fetchAllByWallet(WalletId $walletId, UserId $userId): Collection
    {
        $cacheItem = $this->cache->getItem(sprintf('wallets.%s.transactions', $userId->toInt()));

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $data = $this->databaseRepository->fetchAllByWallet($walletId, $userId);
        $cacheItem->set($data);
        $cacheItem->expiresAfter(3600);
        $this->cache->save($cacheItem);

        return $data;
    }

    public function fetchOneById(TransactionId $transactionId, UserId $userId): TransactionDTO
    {
        $cacheItem = $this->cache->getItem(sprintf('transactions.%s.%s', $userId->toInt(), $transactionId->toInt()));

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $data = $this->databaseRepository->fetchOneById($transactionId, $userId);
        $cacheItem->set($data);
        $cacheItem->expiresAfter(3600);
        $this->cache->save($cacheItem);

        return $data;
    }

    public function fetchAll(UserId $userId): Collection
    {
        $cacheItem = $this->cache->getItem(sprintf('transactions.%s', $userId->toInt()));

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $data = $this->databaseRepository->fetchAll($userId);
        $cacheItem->set($data);
        $cacheItem->expiresAfter(3600);
        $this->cache->save($cacheItem);

        return $data;
    }
}
