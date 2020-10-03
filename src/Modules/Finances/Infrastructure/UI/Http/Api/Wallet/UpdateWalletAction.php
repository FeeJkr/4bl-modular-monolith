<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Wallet;

use App\Common\User\UserId;
use App\Modules\Finances\Application\Wallet\Update\UpdateWalletCommand;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdateWalletAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $userIds = new ArrayCollection();

        if (! empty($request->get('wallet_user_ids'))) {
            $userIds = (new ArrayCollection(explode(', ', $request->get('wallet_user_ids'))))
                ->map(static function (string $id): UserId { return UserId::fromInt((int) $id); });
        }

        $userIds->add($request->get('user_id'));

        $this->bus->dispatch(
            new UpdateWalletCommand(
                WalletId::fromInt((int) $request->get('id')),
                $request->get('user_id'),
                $request->get('wallet_name'),
                new Money((int) $request->get('wallet_start_balance')),
                $userIds
            )
        );

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
