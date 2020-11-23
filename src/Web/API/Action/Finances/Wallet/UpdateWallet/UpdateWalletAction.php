<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\UpdateWallet;

use App\Modules\Finances\Application\Wallet\Update\UpdateWalletCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdateWalletAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $updateWalletRequest = UpdateWalletRequest::createFromServerRequest($request);
        $this->bus->dispatch(
            new UpdateWalletCommand(
                $updateWalletRequest->getWalletId(),
                $updateWalletRequest->getWalletName(),
                $updateWalletRequest->getWalletStartBalance()
            )
        );

        return $this->noContentResponse();
    }
}
