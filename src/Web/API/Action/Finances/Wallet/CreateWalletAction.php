<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet;

use App\Modules\Finances\Application\Wallet\Create\CreateWalletCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Wallet\CreateWalletRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateWalletAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $createWalletRequest = CreateWalletRequest::createFromServerRequest($request);
        $this->bus->dispatch(
            new CreateWalletCommand(
                $createWalletRequest->getWalletName(),
                $createWalletRequest->getWalletStartBalance()
            )
        );

        return $this->noContentResponse();
    }
}
