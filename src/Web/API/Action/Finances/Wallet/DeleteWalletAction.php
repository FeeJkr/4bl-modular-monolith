<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet;

use App\Modules\Finances\Application\Wallet\Delete\DeleteWalletCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Wallet\DeleteWalletRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteWalletAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $deleteWalletRequest = DeleteWalletRequest::createFromServerRequest($request);
        $this->bus->dispatch(
            new DeleteWalletCommand(
                $deleteWalletRequest->getWalletId()
            )
        );

        return $this->noContentResponse();
    }
}
