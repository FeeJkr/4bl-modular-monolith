<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Category\Doctrine;

use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryException;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository as CategoryRepositoryInterface;
use App\Modules\Finances\Domain\Category\CategoryType;
use App\Modules\Finances\Domain\User\UserId;
use DateTime;
use Doctrine\DBAL\Connection;

final class CategoryRepository implements CategoryRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function store(Category $category): void
    {
        $this->connection->executeQuery(
            "INSERT INTO categories (user_id, name, type, icon, created_at) VALUES (:user_id, :name, :type, :icon, :created_at)",
            [
                'user_id' => $category->getUserId()->toInt(),
                'name' => $category->getName(),
                'type' => $category->getType()->getValue(),
                'icon' => $category->getIcon() ?? 'home',
                'created_at' => $category->getCreatedAt()->format('Y-m-d H:i:s'),
            ]
        );
    }

    public function delete(CategoryId $categoryId, UserId $userId): void
    {
        $isDeleted = $this->connection->executeQuery(
            "DELETE FROM categories WHERE user_id = :user_id AND id = :category_id",
            [
                'user_id' => $userId->toInt(),
                'category_id' => $categoryId->toInt(),
            ]
        )->rowCount();

        if ($isDeleted === 0) {
            throw CategoryException::notDeleted($categoryId, $userId);
        }
    }

    public function fetchById(CategoryId $categoryId, UserId $userId): Category
    {
        $data = $this->connection->executeQuery("
            SELECT * FROM categories WHERE id = :id AND user_id = :user_id
        ", [
            'id' => $categoryId->toInt(),
            'user_id' => $userId->toInt(),
        ])->fetchAssociative();

        if ($data === false) {
            throw CategoryException::notFound($categoryId, $userId);
        }

        return new Category(
            CategoryId::fromInt($data['id']),
            UserId::fromInt($data['user_id']),
            $data['name'],
            new CategoryType($data['type']),
            $data['icon'],
            DateTime::createFromFormat('Y-m-d H:i:s', $data['created_at'])
        );
    }

    public function save(Category $category): void
    {
        $this->connection->executeQuery("
            UPDATE categories SET name = :name, type = :type, icon = :icon WHERE id = :id;
        ", [
            'name' => $category->getName(),
            'type' => $category->getType()->getValue(),
            'icon' => $category->getIcon(),
            'id' => $category->getId()->toInt(),
        ]);
    }

    public function fetchAll(UserId $userId): array
    {
        $collection = [];

        $data = $this->connection->executeQuery(
            "SELECT * FROM categories WHERE user_id = :user_id",
            ['user_id' => $userId->toInt()]
        )->fetchAllAssociative();

        foreach ($data as $category) {
            $collection[] = new Category(
                CategoryId::fromInt($category['id']),
                UserId::fromInt($category['user_id']),
                $category['name'],
                new CategoryType($category['type']),
                $category['icon'],
                DateTime::createFromFormat('Y-m-d H:i:s', $category['created_at'])
            );
        }

        return $collection;
    }

    public function fetchAllGroupedByType(UserId $userId): array
    {
        $data = [];
        $categories = $this->fetchAll($userId);

        /** @var Category $category */
        foreach ($categories as $category) {
            $data[$category->getType()->getValue()][] = $category;
        }

        return $data;
    }
}
