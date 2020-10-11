<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet;

use App\Modules\Finances\Application\Wallet\Delete\DeleteWalletCommand;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteWalletAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->bus->dispatch(
            new DeleteWalletCommand(
                WalletId::fromInt((int) $request->get('id')),
                UserId::fromInt($request->get('user_id'))
            )
        );

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
