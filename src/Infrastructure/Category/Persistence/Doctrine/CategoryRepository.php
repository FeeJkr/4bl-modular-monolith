<?php
declare(strict_types=1);

namespace App\Infrastructure\Category\Persistence\Doctrine;

use App\DomainModel\Category\Category;
use App\DomainModel\Category\CategoryException;
use App\DomainModel\Category\CategoryRepository as CategoryRepositoryInterface;
use App\SharedKernel\Category\CategoryId;
use App\SharedKernel\User\UserId;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

final class CategoryRepository implements CategoryRepositoryInterface
{
    private $entityManager;
    private $cache;

    public function __construct(EntityManagerInterface $entityManager, AdapterInterface $cache)
    {
        $this->entityManager = $entityManager;
        $this->cache = $cache;
    }

    public function store(Category $category): void
    {
        $this->entityManager->getConnection()->executeQuery(
            "INSERT INTO categories (user_id, name, type, icon, created_at) VALUES (:user_id, :name, :type, :icon, :created_at)",
            [
                'user_id' => $category->getUserId()->toInt(),
                'name' => $category->getName(),
                'type' => $category->getType()->getValue(),
                'icon' => $category->getIcon() ?? 'home',
                'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
            ]
        );

        $this->cache->clear('categories');
    }

    public function delete(CategoryId $categoryId, UserId $userId): void
    {
        $isDeleted = $this->entityManager->getConnection()->executeQuery(
            "DELETE FROM categories WHERE user_id = :user_id AND id = :category_id",
            [
                'user_id' => $userId->toInt(),
                'category_id' => $categoryId->toInt(),
            ]
        )->rowCount();

        if ($isDeleted === 0) {
            throw CategoryException::notDeleted($categoryId, $userId);
        }

        $this->cache->clear('categories');
    }
}
