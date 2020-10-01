<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Wallet\Doctrine;

use App\Common\User\UserId;
use App\Modules\Finances\Application\Wallet\WalletDTO;
use App\Modules\Finances\Application\Wallet\WalletReadModelRepository as WalletReadModelRepositoryInterface;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

final class WalletReadModelRepository implements WalletReadModelRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetchAll(UserId $userId): ArrayCollection
    {
        $collection = new ArrayCollection();
        $data = $this->entityManager->getConnection()->executeQuery("
            SELECT
                wallets.*,
                (SELECT string_agg(user_id::text, ', ') FROM wallets_users WHERE wallet_id = wallets.id) as user_ids
            FROM wallets
                LEFT JOIN wallets_users ON wallets.id = wallets_users.wallet_id
            WHERE wallets_users.user_id = :user_id;
        ",
            [
                'user_id' => $userId->toInt()
            ]
        )->fetchAll();

        foreach ($data as $wallet) {
            $collection->add(WalletDTO::createFromArray($wallet));
        }

        return $collection;
    }

    public function fetchOneById(WalletId $walletId, UserId $userId): ?WalletDTO
    {
        $data = $this->entityManager->getConnection()->executeQuery("
            SELECT
                wallets.*,
                (SELECT string_agg(user_id::text, ', ') FROM wallets_users WHERE wallet_id = wallets.id) as user_ids
            FROM wallets
                LEFT JOIN wallets_users ON wallets.id = wallets_users.wallet_id
            WHERE wallets_users.user_id = :user_id AND wallets.id = :wallet_id;
        ", [
                'user_id' => $userId->toInt(),
                'wallet_id' => $walletId->toInt(),
            ]
        )->fetch();

        if ($data === false) {
            return null;
        }

        return WalletDTO::createFromArray($data);
    }
}
