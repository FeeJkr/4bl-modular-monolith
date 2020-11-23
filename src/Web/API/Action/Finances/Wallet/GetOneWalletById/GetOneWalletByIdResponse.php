<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\GetOneWalletById;

use App\Modules\Finances\Application\Wallet\GetOneById\WalletDTO;
use DateTimeInterface;

final class GetOneWalletByIdResponse
{
    private int $id;
    private string $name;
    private int $startBalance;
    private int $userId;
    private DateTimeInterface $createdAt;

    public function __construct(
        int $id,
        string $name,
        int $startBalance,
        int $userId,
        DateTimeInterface $createdAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->startBalance = $startBalance;
        $this->userId = $userId;
        $this->createdAt = $createdAt;
    }

    public static function createFromWallet(WalletDTO $walletDTO): self
    {
        return new self(
            $walletDTO->getId(),
            $walletDTO->getName(),
            $walletDTO->getStartBalance(),
            $walletDTO->getUserId(),
            $walletDTO->getCreatedAt()
        );
    }

    public function getResponse(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'startBalance' => $this->startBalance,
            'userId' => $this->userId,
            'createdAt' => $this->createdAt->getTimestamp(),
        ];
    }
}
