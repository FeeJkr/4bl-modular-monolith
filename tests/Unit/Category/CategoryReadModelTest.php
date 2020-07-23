<?php
declare(strict_types=1);

namespace App\Tests\Unit\Category;

use App\Category\ReadModel\CategoryDTO;
use App\Category\ReadModel\CategoryReadModel;
use App\Category\ReadModel\CategoryReadModelException;
use App\Category\ReadModel\CategoryReadModelRepository;
use App\Category\ReadModel\Query\FetchAllCategoriesQuery;
use App\Category\ReadModel\Query\FetchOneCategoryByIdQuery;
use App\Category\SharedKernel\CategoryId;
use App\Category\SharedKernel\CategoryType;
use App\SharedKernel\User\UserId;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

final class CategoryReadModelTest extends TestCase
{
    private $repository;
    private $readModel;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(CategoryReadModelRepository::class);
        $this->readModel = new CategoryReadModel($this->repository);
    }

    public function testFetchAllWithEmptyDatabase(): void
    {
        $this->repository->expects($this->once())->method('fetchAll')->willReturn(
            new ArrayCollection()
        );

        $result = $this->readModel->fetchAll(
            new FetchAllCategoriesQuery(UserId::fromInt(1))
        );

        $this->assertEmpty($result);
    }

    public function testFetchAllWithData(): void
    {
        $this->repository->expects($this->once())->method('fetchAll')->willReturn(
            new ArrayCollection([1, 2, 3, 4])
        );

        $result = $this->readModel->fetchAll(
            new FetchAllCategoriesQuery(UserId::fromInt(1))
        );

        $this->assertEquals([1, 2, 3, 4], $result->toArray());
        $this->assertCount(4, $result);
    }

    public function testFetchOneByIdWithData(): void
    {
        $categoryDTO = new CategoryDTO(
            CategoryId::fromInt(1),
            UserId::fromInt(1),
           'Testing',
            CategoryType::EXPENSE(),
            'home',
            new DateTime()
        );

        $this->repository->expects($this->once())->method('fetchOneById')->willReturn($categoryDTO);

        $result = $this->readModel->fetchOneById(
            new FetchOneCategoryByIdQuery(
                UserId::fromInt(1),
                CategoryId::fromInt(1)
            )
        );

        $this->assertEquals($categoryDTO, $result);
    }

    public function testFetchOneByIdWithEmptyDatabase(): void
    {
        $this->expectException(CategoryReadModelException::class);

        $this->repository->expects($this->once())->method('fetchOneById')->willReturn(null);

        $this->readModel->fetchOneById(
            new FetchOneCategoryByIdQuery(
                UserId::fromInt(1),
                CategoryId::fromInt(1)
            )
        );
    }
}
