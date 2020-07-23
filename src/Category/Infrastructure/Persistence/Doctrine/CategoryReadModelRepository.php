<?php
declare(strict_types=1);

namespace App\Category\Infrastructure\Persistence\Doctrine;

use App\Category\ReadModel\CategoryDTO;
use App\Category\ReadModel\CategoryReadModelRepository as CategoryReadModelRepositoryInterface;
use App\Category\SharedKernel\CategoryId;
use App\SharedKernel\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

final class CategoryReadModelRepository implements CategoryReadModelRepositoryInterface
{
    private $entityManager;
    private $cache;

    public function __construct(
        EntityManagerInterface $entityManager,
        AdapterInterface $cache
    ) {
        $this->entityManager = $entityManager;
        $this->cache = $cache;
    }

    public function fetchAll(UserId $userId): Collection
    {
        $collection = new ArrayCollection();

        $data = $this->entityManager->getConnection()->executeQuery(
            "SELECT * FROM categories WHERE user_id = :user_id",
            ['user_id' => $userId->toInt()]
        )->fetchAll();

        foreach ($data as $category) {
            $collection->add(CategoryDTO::createFromArray($category));
        }

        return $collection;
    }

    public function fetchOneById(UserId $userId, CategoryId $categoryId): ?CategoryDTO
    {
        $data = $this->entityManager->getConnection()->executeQuery(
            "SELECT * FROM categories WHERE user_id = :user_id AND id = :category_id",
            [
                'user_id' => $userId->toInt(),
                'category_id' => $categoryId->toInt(),
            ]
        )->fetch();

        if ($data === false) {
            return null;
        }

        return CategoryDTO::createFromArray($data);
    }
}
