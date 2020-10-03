<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Category\Doctrine;

use App\Common\User\UserId;
use App\Modules\Finances\Application\Category\CategoryDTO;
use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryException;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository as CategoryRepositoryInterface;
use App\Modules\Finances\Domain\Category\CategoryType;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

final class CategoryRepository implements CategoryRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private AdapterInterface $cache;

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

    public function fetchById(CategoryId $categoryId, UserId $userId): Category
    {
        $data = $this->entityManager->getConnection()->executeQuery("
            SELECT * FROM categories WHERE id = :id AND user_id = :user_id
        ", [
            'id' => $categoryId->toInt(),
            'user_id' => $userId->toInt(),
        ])->fetch();

        if ($data === false) {
            throw CategoryException::notFound($categoryId, $userId);
        }

        return new Category(
            CategoryId::fromInt($data['id']),
            UserId::fromInt($data['user_id']),
            $data['name'],
            new CategoryType($data['type']),
            $data['icon']
        );
    }

    public function save(Category $category): void
    {
        $this->entityManager->getConnection()->executeQuery("
            UPDATE categories SET name = :name, type = :type, icon = :icon WHERE id = :id;
        ", [
            'name' => $category->getName(),
            'type' => $category->getType()->getValue(),
            'icon' => $category->getIcon(),
            'id' => $category->getId()->toInt(),
        ]);

        $this->cache->clear('categories');
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
