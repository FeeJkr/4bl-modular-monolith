<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Transaction;

use App\Modules\Finances\Application\Transaction\FetchAllByWallet\FetchAllTransactionsByWalletQuery;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class FetchAllTransactionsByWalletIdAction extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchAllTransactionsByWalletQuery(
            WalletId::fromInt((int) $request->get('wallet_id')),
            $request->get('user_id')
        );

        $result = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult()
            ->toArray();

        return $this->json($result);
    }
}
