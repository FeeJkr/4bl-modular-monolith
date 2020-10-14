<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\Wallet;

use App\Modules\Finances\Application\Wallet\Create\CreateWalletCommand;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserId;
use Symfony\Component\Messenger\MessageBusInterface;

final class DirectCallWalletService implements WalletService
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function createWallet(): void
    {

        $this->bus->dispatch();
    }
}
