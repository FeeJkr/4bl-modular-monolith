<?php

declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Category\Doctrine;

use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\Category\CategoryType;
use App\Modules\Finances\Domain\User\UserId;
use Doctrine\DBAL\Connection;

final class CategoryDbRepository implements CategoryRepository
{
    public function __construct(private Connection $connection){}

    public function store(Category $category): void
    {
        $snapshot = $category->getSnapshot();
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->insert('categories')
            ->values([
                'id' => ':id',
                'user_id' => ':userId',
                'name' => ':name',
                'type' => ':type',
                'icon' => ':icon',
            ])
            ->setParameters([
                'id' => $snapshot->getId(),
                'userId' => $snapshot->getUserId(),
                'name' => $snapshot->getName(),
                'type' => $snapshot->getType(),
                'icon' => $snapshot->getIcon(),
            ]);

        $this->connection->executeQuery($queryBuilder->getSQL(), $queryBuilder->getParameters());
    }

    public function nextIdentity(): CategoryId
    {
        return CategoryId::generate();
    }

    public function getById(CategoryId $id, UserId $userId): Category
    {
        $query = $this->connection
            ->createQueryBuilder()
            ->select(['id', 'user_id', 'name', 'type', 'icon'])
            ->from('categories')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameter('id', $id->toString())
            ->setParameter('userId', $userId->toString());

        $row = $this->connection->executeQuery($query->getSQL(), $query->getParameters())->fetchAssociative();

        return new Category(
            CategoryId::fromString($row['id']),
            UserId::fromString($row['user_id']),
            $row['name'],
            CategoryType::from($row['type']),
            $row['icon']
        );
    }

    public function delete(Category $category): void
    {
        $query = $this->connection
            ->createQueryBuilder()
            ->delete('categories')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameter('id', $category->getSnapshot()->getId())
            ->setParameter('userId', $category->getSnapshot()->getUserId());

        $this->connection->executeQuery($query->getSQL(), $query->getParameters());
    }

    public function save(Category $category): void
    {
        $snapshot = $category->getSnapshot();
        $query = $this->connection
            ->createQueryBuilder()
            ->update('categories')
            ->set('name', ':name')
            ->set('type', ':type')
            ->set('icon', ':icon')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameters([
                'id' => $snapshot->getId(),
                'userId' => $snapshot->getUserId(),
                'name' => $snapshot->getName(),
                'type' => $snapshot->getType(),
                'icon' => $snapshot->getIcon(),
            ]);

        $this->connection->executeQuery($query->getSQL(), $query->getParameters());
    }
}