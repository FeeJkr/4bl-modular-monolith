<?php
declare(strict_types=1);

namespace App\Tests\Unit\Wallet;

use App\SharedKernel\Money;
use App\SharedKernel\User\UserId;
use App\Wallet\Application\Command\CreateWalletCommand;
use App\Wallet\Application\Command\DeleteWalletCommand;
use App\Wallet\Application\Command\UpdateWalletCommand;
use App\Wallet\Application\WalletService;
use App\Wallet\Domain\Wallet;
use App\Wallet\Domain\WalletRepository;
use App\Wallet\SharedKernel\WalletId;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use PHPUnit\Framework\TestCase;

final class WalletServiceTest extends TestCase
{
    private $repository;
    private $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(WalletRepository::class);
        $this->service = new WalletService($this->repository);
    }

    public function testCreateWalletWithValidData(): void
    {
        $this->repository->expects($this->once())->method('store');

        $this->service->createNewWallet(
            new CreateWalletCommand(
                'New wallet',
                new Money(0),
                UserId::fromInt(1)
            )
        );
    }

    public function testCreateWalletWithError(): void
    {
        $this->expectException(Exception::class);

        $this->repository->expects($this->once())->method('store')->willThrowException(
            new Exception('Error')
        );

        $this->service->createNewWallet(
            new CreateWalletCommand(
                'New wallet',
                new Money(0),
                UserId::fromInt(1)
            )
        );
    }

    public function testDeleteWalletWithValidData(): void
    {
        $this->repository->expects($this->once())->method('delete');

        $this->service->deleteWallet(
            new DeleteWalletCommand(
                WalletId::fromInt(1),
                UserId::fromInt(1)
            )
        );
    }

    public function testDeleteWalletWithError(): void
    {
        $this->expectException(Exception::class);

        $this->repository->expects($this->once())->method('delete')->willThrowException(
            new Exception('Error')
        );

        $this->service->deleteWallet(
            new DeleteWalletCommand(
                WalletId::fromInt(1),
                UserId::fromInt(1)
            )
        );
    }

    public function testUpdateWalletWithValidData(): void
    {
        $wallet = new Wallet(
            WalletId::fromInt(1),
            'Testing',
            new Money(1),
            new ArrayCollection([UserId::fromInt(1)])
        );

        $this->repository->expects($this->once())->method('fetchById')->willReturn($wallet);
        $this->repository->expects($this->once())->method('save');

        $this->service->updateWallet(
            new UpdateWalletCommand(
                WalletId::fromInt(1),
                UserId::fromInt(1),
                'Testing new value',
                new Money(1000),
                new ArrayCollection([UserId::fromInt(1), UserId::fromInt(2), UserId::fromInt(3)])
            )
        );

        $this->assertEquals('Testing new value', $wallet->getName());
        $this->assertCount(3, $wallet->getUserIds());
        $this->assertEquals(1000, $wallet->getStartBalance()->getAmount());
    }

    public function testUpdateWalletWithErrorWhileTryFetchWallet(): void
    {
        $this->expectException(Exception::class);

        $this->repository->expects($this->once())->method('fetchById')->willThrowException(
            new Exception('Error')
        );
        $this->repository->expects($this->never())->method('save');

        $this->service->updateWallet(
            new UpdateWalletCommand(
                WalletId::fromInt(1),
                UserId::fromInt(1),
                'Testing new value',
                new Money(1000),
                new ArrayCollection([UserId::fromInt(1), UserId::fromInt(2), UserId::fromInt(3)])
            )
        );
    }

    public function testUpdateWalletWithErrorWhileTrySaveWallet(): void
    {
        $this->expectException(Exception::class);

        $wallet = new Wallet(
            WalletId::fromInt(1),
            'Testing',
            new Money(1),
            new ArrayCollection([UserId::fromInt(1)])
        );

        $this->repository->expects($this->once())->method('fetchById')->willReturn($wallet);
        $this->repository->expects($this->once())->method('save')->willThrowException(
            new Exception('Error')
        );

        $this->service->updateWallet(
            new UpdateWalletCommand(
                WalletId::fromInt(1),
                UserId::fromInt(1),
                'Testing new value',
                new Money(1000),
                new ArrayCollection([UserId::fromInt(1), UserId::fromInt(2), UserId::fromInt(3)])
            )
        );
    }
}
