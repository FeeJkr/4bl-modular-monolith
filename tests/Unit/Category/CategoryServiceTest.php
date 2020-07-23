<?php
declare(strict_types=1);

namespace App\Tests\Unit\Category;

use App\Category\Application\CategoryService;
use App\Category\Application\Command\CreateCategoryCommand;
use App\Category\Application\Command\DeleteCategoryCommand;
use App\Category\Application\Command\UpdateCategoryCommand;
use App\Category\Domain\Category;
use App\Category\Domain\CategoryRepository;
use App\Category\SharedKernel\CategoryId;
use App\Category\SharedKernel\CategoryType;
use App\SharedKernel\User\UserId;
use Exception;
use PHPUnit\Framework\TestCase;

final class CategoryServiceTest extends TestCase
{
    private $repository;
    private $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(CategoryRepository::class);
        $this->service = new CategoryService($this->repository);
    }

    public function testCreateCategoryWithValidData(): void
    {
        $this->repository->expects($this->once())->method('store');

        $this->service->createCategory(
            new CreateCategoryCommand(
                UserId::fromInt(1234),
                'Testing',
                CategoryType::EXPENSE(),
                'test'
            )
        );
    }

    public function testCreateCategoryWithError(): void
    {
        $this->expectException(Exception::class);

        $this->repository->expects($this->once())->method('store')->willThrowException(
            new Exception('Error')
        );

        $this->service->createCategory(
            new CreateCategoryCommand(
                UserId::fromInt(1234),
                'Testing',
                CategoryType::EXPENSE(),
                'test'
            )
        );
    }

    public function testDeleteCategoryWithValidData(): void
    {
        $this->repository->expects($this->once())->method('delete');

        $this->service->deleteCategory(
            new DeleteCategoryCommand(
                CategoryId::fromInt(1),
                UserId::fromInt(1)
            )
        );
    }

    public function testDeleteCategoryWithError(): void
    {
        $this->expectException(Exception::class);

        $this->repository->expects($this->once())->method('delete')->willThrowException(
            new Exception('error')
        );

        $this->service->deleteCategory(
            new DeleteCategoryCommand(
                CategoryId::fromInt(1),
                UserId::fromInt(1)
            )
        );
    }

    public function testUpdateCategoryWithValidData(): void
    {
        $category = new Category(
            CategoryId::fromInt(1),
            UserId::fromInt(1),
            'Testing',
            CategoryType::EXPENSE(),
            'test'
        );

        $this->repository->expects($this->once())->method('fetchById')->willReturn($category);
        $this->repository->expects($this->once())->method('save');

        $this->service->updateCategory(
            new UpdateCategoryCommand(
                CategoryId::fromInt(1),
                UserId::fromInt(2),
                'Testing new value',
                CategoryType::INCOME(),
                'home'
            )
        );

        $this->assertEquals('Testing new value', $category->getName());
        $this->assertEquals(CategoryType::INCOME()->getValue(), $category->getType()->getValue());
        $this->assertEquals('home', $category->getIcon());
    }

    public function testUpdateCategoryWithErrorWhileTryFetchFromRepository(): void
    {
        $this->expectException(Exception::class);

        $this->repository->expects($this->once())->method('fetchById')->willThrowException(
            new Exception('Error')
        );
        $this->repository->expects($this->never())->method('save');

        $this->service->updateCategory(
            new UpdateCategoryCommand(
                CategoryId::fromInt(1),
                UserId::fromInt(2),
                'Testing new value',
                CategoryType::INCOME(),
                'home'
            )
        );
    }

    public function testUpdateCategoryWithErrorWhileTrySaveCategory(): void
    {
        $this->expectException(Exception::class);

        $category = new Category(
            CategoryId::fromInt(1),
            UserId::fromInt(1),
            'Testing',
            CategoryType::EXPENSE(),
            'test'
        );

        $this->repository->expects($this->once())->method('fetchById')->willReturn($category);
        $this->repository->expects($this->once())->method('save')->willThrowException(
            new Exception('Error')
        );

        $this->service->updateCategory(
            new UpdateCategoryCommand(
                CategoryId::fromInt(1),
                UserId::fromInt(2),
                'Testing new value',
                CategoryType::INCOME(),
                'home'
            )
        );
    }
}
