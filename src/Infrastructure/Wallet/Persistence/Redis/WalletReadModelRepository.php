<?php
declare(strict_types=1);

namespace App\Infrastructure\Wallet\Persistence\Redis;

use App\ReadModel\Wallet\WalletDTO;
use App\ReadModel\Wallet\WalletReadModelRepository as WalletReadModelRepositoryInterface;
use App\SharedKernel\User\UserId;
use App\SharedKernel\Wallet\WalletId;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Cache\Adapter\AdapterInterface;

final class WalletReadModelRepository implements WalletReadModelRepositoryInterface
{
    private $cache;
    private $databaseRepository;

    public function __construct(AdapterInterface $cache, WalletReadModelRepositoryInterface $databaseRepository)
    {
        $this->cache = $cache;
        $this->databaseRepository = $databaseRepository;
    }

    public function fetchAll(UserId $userId): ArrayCollection
    {
        $cacheItem = $this->cache->getItem(sprintf('wallets.%s', $userId->toInt()));

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $data = $this->databaseRepository->fetchAll($userId);
        $cacheItem->set($data);
        $cacheItem->expiresAfter(3600);
        $this->cache->save($cacheItem);

        return $data;
    }

    public function fetchOneById(WalletId $walletId, UserId $userId): ?WalletDTO
    {
        $cacheItem = $this->cache->getItem(sprintf('wallets.%s.%s', $userId->toInt(), $walletId->toInt()));

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $data = $this->databaseRepository->fetchOneById($walletId, $userId);

        if ($data === null) {
            return null;
        }

        $cacheItem->set($data);
        $cacheItem->expiresAfter(3600);
        $this->cache->save($cacheItem);

        return $data;
    }
}
