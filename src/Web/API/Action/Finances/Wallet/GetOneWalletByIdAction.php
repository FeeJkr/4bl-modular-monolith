<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet;

use App\Modules\Finances\Application\Wallet\GetOneById\GetOneWalletByIdQuery;
use App\Modules\Finances\Application\Wallet\GetOneById\WalletDTO;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Wallet\GetOneWalletByIdRequest;
use App\Web\API\Response\Finances\Wallet\WalletResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class GetOneWalletByIdAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $getWalletByIdRequest = GetOneWalletByIdRequest::createFromServerRequest($request);
        /** @var WalletDTO $wallet */
        $wallet = $this->bus
            ->dispatch(new GetOneWalletByIdQuery($getWalletByIdRequest->getWalletId()))
            ->last(HandledStamp::class)
            ->getResult();

        $response = new WalletResponse(
            $wallet->getId(),
            $wallet->getName(),
            $wallet->getStartBalance(),
            $wallet->getUserId(),
            $wallet->getCreatedAt()
        );

        return $this->json($response->getResponse());
    }
}
