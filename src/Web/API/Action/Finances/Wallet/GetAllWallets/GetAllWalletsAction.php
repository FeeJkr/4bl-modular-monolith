<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\GetAllWallets;

use App\Modules\Finances\Application\Wallet\GetAll\GetAllWalletsQuery;
use App\Modules\Finances\Application\Wallet\GetAll\WalletsCollection;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class GetAllWalletsAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var WalletsCollection $wallets */
        $wallets = $this->bus
            ->dispatch(new GetAllWalletsQuery())
            ->last(HandledStamp::class)
            ->getResult();

        $response = GetAllWalletsResponse::createFromCollection($wallets);

        return $this->json(
            $response->getResponse()
        );
    }
}
