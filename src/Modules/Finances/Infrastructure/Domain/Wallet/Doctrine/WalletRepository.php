<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Wallet\Doctrine;

use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\Wallet;
use App\Modules\Finances\Domain\Wallet\WalletException;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\Modules\Finances\Domain\Wallet\WalletRepository as WalletRepositoryInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

final class WalletRepository implements WalletRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function store(Wallet $wallet): void
    {
        $this->entityManager->getConnection()->executeQuery("
            INSERT INTO wallets (user_id, name, start_balance, created_at) 
            VALUES (:user_id, :name, :start_balance, :created_at);
        ", [
            'user_id' => $wallet->getUserId()->toInt(),
            'name' => $wallet->getName(),
            'start_balance' => $wallet->getStartBalance()->getAmount(),
            'created_at' => $wallet->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
    }

    public function delete(WalletId $walletId, UserId $userId): void
    {
        $rowsDeleted = $this->entityManager->getConnection()->executeQuery("
            DELETE FROM wallets WHERE id = :id AND user_id = :user_id 
        ", [
            'id' => $walletId->toInt(),
            'user_id' => $userId->toInt(),
        ])->rowCount();

        if ($rowsDeleted === 0) {
            throw WalletException::notDeleted($walletId, $userId);
        }
    }

    public function fetchById(WalletId $walletId, UserId $userId): Wallet
    {
        $data = $this->entityManager->getConnection()->executeQuery("
            SELECT * FROM wallets WHERE user_id = :user_id AND id = :id;
        ", [
            'user_id' => $userId->toInt(),
            'id' => $walletId->toInt(),
        ])->fetchAssociative();

        if ($data === false) {
            throw WalletException::notFound($walletId, $userId);
        }

        return new Wallet(
            WalletId::fromInt($data['id']),
            $data['name'],
            new Money($data['start_balance']),
            UserId::fromInt($data['user_id']),
            DateTime::createFromFormat('Y-m-d H:i:s', $data['created_at'])
        );
    }

    public function save(Wallet $wallet): void
    {
        $this->entityManager->getConnection()->executeQuery("
            UPDATE wallets SET name = :name, start_balance = :start_balance, user_id = :user_id WHERE id = :id;
        ", [
            'name' => $wallet->getName(),
            'start_balance' => $wallet->getStartBalance()->getAmount(),
            'user_id' => $wallet->getUserId()->toInt(),
            'id' => $wallet->getId()->toInt(),
        ]);
    }

    public function fetchAll(UserId $userId): array
    {
        $collection = [];
        $data = $this->entityManager->getConnection()->executeQuery("
            SELECT * FROM wallets WHERE user_id = :user_id;
        ",
            [
                'user_id' => $userId->toInt()
            ]
        )->fetchAllAssociative();

        foreach ($data as $wallet) {
            $collection[] = new Wallet(
                WalletId::fromInt($wallet['id']),
                $wallet['name'],
                new Money($wallet['start_balance']),
                UserId::fromInt($wallet['user_id']),
                DateTime::createFromFormat('Y-m-d H:i:s', $wallet['created_at'])
            );
        }

        return $collection;
    }
}
