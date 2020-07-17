<?php
declare(strict_types=1);

namespace App\Infrastructure\Category\Persistence\Doctrine;

use App\ReadModel\Category\CategoryDTOFactory;
use App\ReadModel\Category\CategoryReadModelRepository as CategoryReadModelRepositoryInterface;
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
            $collection->add(CategoryDTOFactory::createFromArray($category));
        }

        return $collection;
    }
}
