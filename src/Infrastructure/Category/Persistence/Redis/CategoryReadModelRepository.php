<?php
declare(strict_types=1);

namespace App\Infrastructure\Category\Persistence\Redis;

use App\ReadModel\Category\CategoryDTO;
use App\ReadModel\Category\CategoryReadModelRepository as CategoryReadModelRepositoryInterface;
use App\SharedKernel\Category\CategoryId;
use App\SharedKernel\User\UserId;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Cache\Adapter\AdapterInterface;

final class CategoryReadModelRepository implements CategoryReadModelRepositoryInterface
{
    private $databaseRepository;
    private $cache;

    public function __construct(
        CategoryReadModelRepositoryInterface $databaseRepository,
        AdapterInterface $cache
    ) {
        $this->databaseRepository = $databaseRepository;
        $this->cache = $cache;
    }

    public function fetchAll(UserId $userId): Collection
    {
        $cacheItem = $this->cache->getItem(sprintf('categories.%s', $userId->toInt()));

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $data = $this->databaseRepository->fetchAll($userId);
        $cacheItem->set($data);
        $cacheItem->expiresAfter(3600);
        $this->cache->save($cacheItem);

        return $data;
    }

    public function fetchOneById(UserId $userId, CategoryId $categoryId): ?CategoryDTO
    {
        $cacheItem = $this->cache->getItem(sprintf('categories.%s.%s', $userId->toInt(), $categoryId->toInt()));

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $data = $this->databaseRepository->fetchOneById($userId, $categoryId);

        if ($data === null) {
            return null;
        }

        $cacheItem->set($data);
        $cacheItem->expiresAfter(3600);
        $this->cache->save($cacheItem);

        return $data;
    }
}
