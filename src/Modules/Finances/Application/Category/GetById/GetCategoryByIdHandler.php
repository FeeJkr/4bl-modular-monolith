<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\GetById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Finances\Application\Category\CategoryDTO;
use Doctrine\DBAL\Connection;

final class GetCategoryByIdHandler implements QueryHandler
{
    public function __construct(private Connection $connection){}

    public function __invoke(GetCategoryByIdQuery $query): CategoryDTO
    {
        $queryBuilder = $this->connection
            ->createQueryBuilder()
            ->select(['id', 'name', 'type', 'icon'])
            ->from('categories')
            ->where('id = :id')
            ->setParameter('id', $query->getId());

        $row = $this->connection
            ->executeQuery($queryBuilder->getSQL(), $queryBuilder->getParameters())
            ->fetchAssociative();

        return CategoryDTO::createFromRow($row);
    }
}