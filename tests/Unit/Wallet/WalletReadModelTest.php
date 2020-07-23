<?php
declare(strict_types=1);

namespace App\Tests\Unit\Wallet;

use App\SharedKernel\Money;
use App\SharedKernel\User\UserId;
use App\Wallet\ReadModel\Query\FetchAllWalletsQuery;
use App\Wallet\ReadModel\Query\FetchOneWalletByIdQuery;
use App\Wallet\ReadModel\WalletDTO;
use App\Wallet\ReadModel\WalletReadModel;
use App\Wallet\ReadModel\WalletReadModelException;
use App\Wallet\ReadModel\WalletReadModelRepository;
use App\Wallet\SharedKernel\WalletId;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

final class WalletReadModelTest extends TestCase
{
    private $repository;
    private $readModel;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(WalletReadModelRepository::class);
        $this->readModel = new WalletReadModel($this->repository);
    }

    public function testFetchAllWithData(): void
    {
        $this->repository->expects($this->once())->method('fetchAll')->willReturn(
            new ArrayCollection([1, 2, 3, 4])
        );

        $result = $this->readModel->fetchAll(
            new FetchAllWalletsQuery(
                UserId::fromInt(1)
            )
        );

        $this->assertEquals([1, 2, 3, 4], $result->toArray());
        $this->assertCount(4, $result);
    }

    public function testFetchAllWithEmptyDatabase(): void
    {
        $this->repository->expects($this->once())->method('fetchAll')->willReturn(
            new ArrayCollection()
        );

        $result = $this->readModel->fetchAll(
            new FetchAllWalletsQuery(
                UserId::fromInt(1)
            )
        );

        $this->assertEmpty($result);
    }

    public function testFetchOneByIdWithData(): void
    {
        $walletDTO = new WalletDTO(
            WalletId::fromInt(1),
            'Testing',
            new Money(1000),
            new ArrayCollection([UserId::fromInt(1)]),
            new DateTime()
        );

        $this->repository->expects($this->once())->method('fetchOneById')->willReturn($walletDTO);

        $result = $this->readModel->fetchOneById(
            new FetchOneWalletByIdQuery(
                WalletId::fromInt(1),
                UserId::fromInt(1)
            )
        );

        $this->assertEquals($walletDTO, $result);
    }

    public function testFetchOneByIdWithEmptyDatabase(): void
    {
        $this->expectException(WalletReadModelException::class);

        $this->repository->expects($this->once())->method('fetchOneById')->willReturn(null);

        $this->readModel->fetchOneById(
            new FetchOneWalletByIdQuery(
                WalletId::fromInt(1),
                UserId::fromInt(1)
            )
        );
    }
}
