<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet;

use App\Modules\Finances\Application\Wallet\FetchOneById\FetchOneWalletByIdQuery;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class FetchOneWalletByIdAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchOneWalletByIdQuery(
            WalletId::fromInt((int) $request->get('id')),
            UserId::fromInt($request->get('user_id'))
        );

        $result = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return new JsonResponse($result);
    }
}
