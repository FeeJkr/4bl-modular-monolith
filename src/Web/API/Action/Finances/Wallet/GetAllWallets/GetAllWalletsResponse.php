<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\GetAllWallets;

use App\Modules\Finances\Application\Wallet\GetAll\WalletDTO;
use App\Modules\Finances\Application\Wallet\GetAll\WalletsCollection;

final class GetAllWalletsResponse
{
    private array $wallets;

    public function __construct(array ...$wallets)
    {
        $this->wallets = $wallets;
    }

    public static function createFromCollection(WalletsCollection $collection): self
    {
        $data = [];

        /** @var WalletDTO $wallet */
        foreach($collection->getWallets() as $wallet) {
            $data[] = [
                'id' => $wallet->getId(),
                'name' => $wallet->getName(),
                'startBalance' => $wallet->getStartBalance(),
                'userId' => $wallet->getUserId(),
                'createdAt' => $wallet->getCreatedAt(),
            ];
        }

        return new self(...$data);
    }

    public function getResponse(): array
    {
        return $this->wallets;
    }
}
